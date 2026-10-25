<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TravelRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TravelManagementController extends Controller
{
   
    public function index(Request $request)
    {
        
        $query = TravelRecord::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('enquiry_number', 'like', "%{$search}%")
                    ->orWhere('booking_number', 'like', "%{$search}%")
                    ->orWhere('destination', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        if ($request->filled('from')) {
            $query->whereDate('enquiry_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('enquiry_at', '<=', $request->to);
        }

        $records = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'enquiries' => TravelRecord::count(),
            'new' => TravelRecord::where('status', 'New Enquiry')->count(),
            'confirmed' => TravelRecord::where('status', 'Confirmed')->count(),
            'followups' => TravelRecord::whereNotNull('follow_up_at')
                ->where('follow_up_at', '<=', now())
                ->whereNotIn('status', ['Confirmed', 'Cancelled', 'Lost'])
                ->count(),
        ];

        return view('admin.travel-management.index', compact('records', 'stats'));
    }

    public function create()
    {
        return view('admin.travel-management.form', [
            'record' => new TravelRecord(),
            'editing' => false,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        $data['enquiry_number'] = $this->generateNumber('TN-ENQ-');
        $data['enquiry_at'] = now();

        $this->processDetails($request, $data);
        $this->processDocuments($request, $data);

        $data['payment_history'] = $this->paymentHistory($request);

        TravelRecord::create($data);

        return redirect()
            ->route('admin.travel-management.index')
            ->with('success', 'Travel record created successfully.');
    }

    public function edit(TravelRecord $travelRecord)
    {
        return view('admin.travel-management.form', [
            'record' => $travelRecord,
            'editing' => true,
        ]);
    }

    public function update(Request $request, TravelRecord $travelRecord)
    {
        $data = $this->validatedData($request, $travelRecord);

        $this->processDetails($request, $data, $travelRecord);
        $this->processDocuments($request, $data, $travelRecord);

        // Preserve the existing payment history unless a new payment is entered.
        $history = $this->paymentHistory($request, $travelRecord);

        if ($history !== null) {
            $data['payment_history'] = $history;
        }

        $travelRecord->update($data);

        return redirect()
            ->route('admin.travel-management.index')
            ->with('success', 'Travel record updated successfully.');
    }

    public function destroy(TravelRecord $travelRecord)
    {
        foreach (($travelRecord->documents ?? []) as $document) {
            if (!empty($document['path'])) {
                Storage::disk('public')->delete($document['path']);
            }
        }

        $travelRecord->delete();

        return redirect()
            ->route('admin.travel-management.index')
            ->with('success', 'Travel record deleted successfully.');
    }

    private function validatedData(
        Request $request,
        ?TravelRecord $record = null
    ): array {
        $id = $record?->id;

        $data = $request->validate([
            'customer_name' => 'required|string|max:180',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:180',
            'source' => [
                'required',
                Rule::in([
                    'Website', 'Instagram', 'Facebook', 'Google',
                    'WhatsApp', 'Phone Call', 'Referral', 'Other',
                ]),
            ],
            'destination' => 'required|string|max:180',
            'travel_date' => 'nullable|date',
            'return_date' => 'nullable|date|after_or_equal:travel_date',
            'adults' => 'required|integer|min:1',
            'children' => 'required|integer|min:0',
            'infants' => 'required|integer|min:0',
            'budget' => 'nullable|numeric|min:0',
            'requirements' => 'nullable|string',
            'status' => [
                'required',
                Rule::in([
                    'New Enquiry', 'Contacted', 'Quotation Sent',
                    'Follow-up', 'Negotiation', 'Confirmed',
                    'Cancelled', 'Lost', 'Completed',
                ]),
            ],
            'follow_up_at' => 'nullable|date',
            'follow_up_notes' => 'nullable|string',
            'booking_number' => [
                'nullable', 'string', 'max:80',
                Rule::unique('travel_records', 'booking_number')->ignore($id),
            ],
            'package_name' => 'nullable|string|max:180',
            'duration' => 'nullable|string|max:80',
            'adult_rate' => 'nullable|numeric|min:0',
            'child_rate' => 'nullable|numeric|min:0',
            'flight_cost' => 'nullable|numeric|min:0',
            'accommodation_cost' => 'nullable|numeric|min:0',
            'transfer_cost' => 'nullable|numeric|min:0',
            'activities_cost' => 'nullable|numeric|min:0',
            'permit_cost' => 'nullable|numeric|min:0',
            'other_charges' => 'nullable|numeric|min:0',
            'agency_margin' => 'nullable|numeric|min:0',
            'inclusions' => 'nullable|string',
            'exclusions' => 'nullable|string',

            'flight_details' => 'nullable|string',
            'hotel_details' => 'nullable|string',
            'operations_details' => 'nullable|string',
            'permit_details' => 'nullable|string',

            'total_amount' => 'nullable|numeric|min:0',
            'advance_received' => 'nullable|numeric|min:0',
            'last_payment_date' => 'nullable|date',
            'payment_mode' => 'nullable|string|max:80',
            'balance_due_date' => 'nullable|date',
            'payment_status' => [
                'required',
                Rule::in(['Pending', 'Partially Paid', 'Paid', 'Refunded']),
            ],
            'payment_amount' => 'nullable|numeric|gt:0',
            'payment_date' => 'nullable|date',
            'payment_method' => 'nullable|string|max:80',
            'payment_note' => 'nullable|string|max:500',

            'documents.*' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png,webp,doc,docx',
        ]);

        // Defaults for optional numeric inputs.
        foreach ([
            'adult_rate', 'child_rate', 'flight_cost',
            'accommodation_cost', 'transfer_cost',
            'activities_cost', 'permit_cost', 'other_charges',
            'agency_margin', 'advance_received',
        ] as $field) {
            $data[$field] = $data[$field] ?? 0;
        }

        $data['adults'] = $data['adults'] ?? 1;
        $data['children'] = $data['children'] ?? 0;
        $data['infants'] = $data['infants'] ?? 0;

        // Calculate the total selling price if not manually provided.
        $data['total_amount'] = $request->filled('total_amount')
            ? (float) $request->total_amount
            : (
                ((float) $data['adult_rate'] * (int) $data['adults'])
                + ((float) $data['child_rate'] * (int) $data['children'])
                + (float) $data['flight_cost']
                + (float) $data['accommodation_cost']
                + (float) $data['transfer_cost']
                + (float) $data['activities_cost']
                + (float) $data['permit_cost']
                + (float) $data['other_charges']
                + (float) $data['agency_margin']
            );

        unset(
            $data['flight_details'],
            $data['hotel_details'],
            $data['operations_details'],
            $data['permit_details'],
            $data['payment_amount'],
            $data['payment_date'],
            $data['payment_method'],
            $data['payment_note']
        );

        return $data;
    }

    private function processDetails(
        Request $request,
        array &$data,
        ?TravelRecord $record = null
    ): void {
        foreach ([
            'flight_details',
            'hotel_details',
            'operations_details',
            'permit_details',
        ] as $field) {
            $raw = trim((string) $request->input($field, ''));

            if ($raw === '') {
                if (!$record) {
                    $data[$field] = null;
                }
                continue;
            }

            // Details are stored as one item per line.
            $data[$field] = array_values(array_filter(
                array_map('trim', preg_split('/\r\n|\r|\n/', $raw))
            ));
        }

        $inclusions = trim((string) $request->input('inclusions', ''));
        $exclusions = trim((string) $request->input('exclusions', ''));

        $data['inclusions'] = $inclusions !== '' ? $inclusions : null;
        $data['exclusions'] = $exclusions !== '' ? $exclusions : null;

        if ($request->input('status') === 'Confirmed'
            && empty($record?->booking_number)
            && empty($request->input('booking_number'))) {
            $data['booking_number'] = $this->generateNumber('TN-BKG-');
        }
    }

    private function processDocuments(
        Request $request,
        array &$data,
        ?TravelRecord $record = null
    ): void {
        $documents = $record?->documents ?? [];

        foreach ($request->file('documents', []) as $file) {
            if (!$file) {
                continue;
            }

            $path = $file->store('travel-documents', 'public');

            $documents[] = [
                'name' => $file->getClientOriginalName(),
                'path' => $path,
                'uploaded_at' => now()->toDateTimeString(),
            ];
        }

        $data['documents'] = $documents ?: null;
    }

    private function paymentHistory(
        Request $request,
        ?TravelRecord $record = null
    ): ?array {
        $amount = (float) $request->input('payment_amount', 0);

        if ($amount <= 0) {
            return $record?->payment_history;
        }

        $history = $record?->payment_history ?? [];

        $history[] = [
            'amount' => $amount,
            'date' => $request->input('payment_date') ?: now()->toDateString(),
            'method' => $request->input('payment_method') ?: 'Other',
            'note' => $request->input('payment_note'),
        ];

        return $history;
    }

    private function generateNumber(string $prefix): string
    {
        do {
            $number = $prefix . now()->format('Ymd') . '-'
                . strtoupper(Str::random(5));
        } while (
            TravelRecord::where('enquiry_number', $number)->exists()
            || TravelRecord::where('booking_number', $number)->exists()
        );

        return $number;
    }
}