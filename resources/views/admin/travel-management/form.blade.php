
@extends('admin.layout')

@section('title', $editing ? 'Edit Travel Record' : 'Add Travel Record')

@section('content')
@php
    $value = fn ($field, $default = '') =>
        old($field, $record->{$field} ?? $default);

    $details = fn ($field) =>
        old($field, implode("\n", $record->{$field} ?? []));

    $sections = [
        'flight_details' => 'Flight Details',
        'hotel_details' => 'Hotel, Resort & Rooms',
        'operations_details' => 'Transport & Activities',
        'permit_details' => 'Permit Details',
    ];

    $statuses = [
        'New Enquiry', 'Contacted', 'Quotation Sent',
        'Follow-up', 'Negotiation', 'Confirmed',
        'Cancelled', 'Lost', 'Completed',
    ];

    $sources = [
        'Website', 'Instagram', 'Facebook', 'Google',
        'WhatsApp', 'Phone Call', 'Referral', 'Other',
    ];
@endphp

<div class="page travel-page">
    <div class="page-header">
        <div>
            <small>TRIPNEST CRM</small>
            <h1>{{ $editing ? 'Edit Travel Record' : 'Add Travel Record' }}</h1>
            <p>Manage customer enquiries, quotations, bookings and trip arrangements.</p>
        </div>

        <a href="{{ route('admin.travel-management.index') }}" class="btn-secondary">
            &larr; Back to Records
        </a>
    </div>

    @if ($errors->any())
        <div class="travel-alert">
            <strong>Please correct the following errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ $editing
            ? route('admin.travel-management.update', $record)
            : route('admin.travel-management.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="travel-form"
    >
        @csrf

        @if ($editing)
            @method('PUT')
        @endif

        {{-- 1. CUSTOMER AND ENQUIRY --}}
        <section class="form-section">
            <h3 class="section-title">1. Enquiry &amp; Customer Details</h3>

            @if ($editing && $record->enquiry_number)
                <p class="record-reference">
                    Enquiry No: <strong>{{ $record->enquiry_number }}</strong>
                </p>
            @endif

            <div class="form-grid">
                <div class="form-field">
                    <label for="customer_name">Customer Name <span class="required">*</span></label>
                    <input type="text" id="customer_name" name="customer_name"
                        value="{{ $value('customer_name') }}" required maxlength="180">
                </div>

                <div class="form-field">
                    <label for="phone">Mobile / WhatsApp <span class="required">*</span></label>
                    <input type="text" id="phone" name="phone"
                        value="{{ $value('phone') }}" required maxlength="30">
                </div>

                <div class="form-field">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email"
                        value="{{ $value('email') }}" maxlength="180">
                </div>

                <div class="form-field">
                    <label for="source">Enquiry Source <span class="required">*</span></label>
                    <select id="source" name="source" required>
                        @foreach ($sources as $source)
                            <option value="{{ $source }}"
                                @selected($value('source', 'Website') === $source)>
                                {{ $source }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-field">
                    <label for="destination">Destination <span class="required">*</span></label>
                    <input type="text" id="destination" name="destination"
                        placeholder="e.g. Lakshadweep"
                        value="{{ $value('destination') }}" required maxlength="180">
                </div>

                <div class="form-field">
                    <label for="package_name">Package Name</label>
                    <input type="text" id="package_name" name="package_name"
                        placeholder="e.g. Island Holiday Package"
                        value="{{ $value('package_name') }}" maxlength="180">
                </div>

                <div class="form-field">
                    <label for="travel_date">Travel Date</label>
                    <input type="date" id="travel_date" name="travel_date"
                        value="{{ $value('travel_date') instanceof \Carbon\Carbon ? $value('travel_date')->format('Y-m-d') : $value('travel_date') }}">
                </div>

                <div class="form-field">
                    <label for="return_date">Return Date</label>
                    <input type="date" id="return_date" name="return_date"
                        value="{{ $value('return_date') instanceof \Carbon\Carbon ? $value('return_date')->format('Y-m-d') : $value('return_date') }}">
                </div>

                <div class="form-field">
                    <label for="adults">Adults <span class="required">*</span></label>
                    <input type="number" id="adults" name="adults" min="1"
                        value="{{ $value('adults', 1) }}" required>
                </div>

                <div class="form-field">
                    <label for="children">Children</label>
                    <input type="number" id="children" name="children" min="0"
                        value="{{ $value('children', 0) }}">
                </div>

                <div class="form-field">
                    <label for="infants">Infants</label>
                    <input type="number" id="infants" name="infants" min="0"
                        value="{{ $value('infants', 0) }}">
                </div>

                <div class="form-field">
                    <label for="budget">Customer Budget (₹)</label>
                    <input type="number" id="budget" name="budget" min="0" step="0.01"
                        value="{{ $value('budget') }}">
                </div>

                <div class="form-field">
                    <label for="duration">Duration</label>
                    <input type="text" id="duration" name="duration"
                        placeholder="4 Days / 3 Nights"
                        value="{{ $value('duration') }}" maxlength="80">
                </div>

                <div class="form-field">
                    <label for="status">Enquiry / Booking Status <span class="required">*</span></label>
                    <select id="status" name="status" required>
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}"
                                @selected($value('status', 'New Enquiry') === $status)>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-field">
                    <label for="booking_number">Booking Number</label>
                    <input type="text" id="booking_number" name="booking_number"
                        placeholder="Auto-generated when confirmed"
                        value="{{ $value('booking_number') }}" maxlength="80">
                </div>

                <div class="form-field">
                    <label for="follow_up_at">Follow-up Date &amp; Time</label>
                    <input type="datetime-local" id="follow_up_at" name="follow_up_at"
                        value="{{ $value('follow_up_at') instanceof \Carbon\Carbon ? $value('follow_up_at')->format('Y-m-d\TH:i') : $value('follow_up_at') }}">
                </div>

                <div class="form-field full-width">
                    <label for="requirements">Customer Requirements / Notes</label>
                    <textarea id="requirements" name="requirements"
                        placeholder="Special requests, preferences or enquiry details">{{ $value('requirements') }}</textarea>
                </div>

                <div class="form-field full-width">
                    <label for="follow_up_notes">Follow-up Notes</label>
                    <textarea id="follow_up_notes" name="follow_up_notes"
                        placeholder="Record the latest conversation and next action">{{ $value('follow_up_notes') }}</textarea>
                </div>
            </div>
        </section>

        {{-- 2. QUOTATION AND COSTS --}}
        <section class="form-section">
            <h3 class="section-title">2. Quotation &amp; Cost Breakdown</h3>
            <p class="section-description">
                Enter the selling rates and trip costs. The total is calculated by the controller if left blank.
            </p>

            <div class="form-grid">
                <div class="form-field">
                    <label for="adult_rate">Adult Rate (₹)</label>
                    <input type="number" id="adult_rate" name="adult_rate" min="0" step="0.01"
                        value="{{ $value('adult_rate', 0) }}">
                </div>

                <div class="form-field">
                    <label for="child_rate">Child Rate (₹)</label>
                    <input type="number" id="child_rate" name="child_rate" min="0" step="0.01"
                        value="{{ $value('child_rate', 0) }}">
                </div>

                <div class="form-field">
                    <label for="flight_cost">Flight Cost (₹)</label>
                    <input type="number" id="flight_cost" name="flight_cost" min="0" step="0.01"
                        value="{{ $value('flight_cost', 0) }}">
                </div>

                <div class="form-field">
                    <label for="accommodation_cost">Accommodation Cost (₹)</label>
                    <input type="number" id="accommodation_cost" name="accommodation_cost" min="0" step="0.01"
                        value="{{ $value('accommodation_cost', 0) }}">
                </div>

                <div class="form-field">
                    <label for="transfer_cost">Transfer Cost (₹)</label>
                    <input type="number" id="transfer_cost" name="transfer_cost" min="0" step="0.01"
                        value="{{ $value('transfer_cost', 0) }}">
                </div>

                <div class="form-field">
                    <label for="activities_cost">Activities Cost (₹)</label>
                    <input type="number" id="activities_cost" name="activities_cost" min="0" step="0.01"
                        value="{{ $value('activities_cost', 0) }}">
                </div>

                <div class="form-field">
                    <label for="permit_cost">Permit Cost (₹)</label>
                    <input type="number" id="permit_cost" name="permit_cost" min="0" step="0.01"
                        value="{{ $value('permit_cost', 0) }}">
                </div>

                <div class="form-field">
                    <label for="other_charges">Other Charges (₹)</label>
                    <input type="number" id="other_charges" name="other_charges" min="0" step="0.01"
                        value="{{ $value('other_charges', 0) }}">
                </div>

                <div class="form-field">
                    <label for="agency_margin">Agency Margin / Profit (₹)</label>
                    <input type="number" id="agency_margin" name="agency_margin" min="0" step="0.01"
                        value="{{ $value('agency_margin', 0) }}">
                </div>

                <div class="form-field">
                    <label for="total_amount">Final Selling Price (₹)</label>
                    <input type="number" id="total_amount" name="total_amount" min="0" step="0.01"
                        value="{{ $value('total_amount') }}">
                    <small class="help-text">Leave blank to calculate using the rates and costs.</small>
                </div>

                <div class="form-field full-width">
                    <label for="inclusions">Package Inclusions</label>
                    <textarea id="inclusions" name="inclusions"
                        placeholder="Enter included services">{{ $value('inclusions') }}</textarea>
                </div>

                <div class="form-field full-width">
                    <label for="exclusions">Package Exclusions</label>
                    <textarea id="exclusions" name="exclusions"
                        placeholder="Enter services not included">{{ $value('exclusions') }}</textarea>
                </div>
            </div>
        </section>

        {{-- 3. FLIGHT, HOTEL, OPERATIONS AND PERMITS --}}
        @foreach ($sections as $field => $heading)
            <section class="form-section">
                <h3 class="section-title">
                    {{ $loop->iteration + 2 }}. {{ $heading }}
                </h3>

                <div class="form-grid">
                    <div class="form-field full-width">
                        <label for="{{ $field }}">{{ $heading }}</label>
                        <textarea id="{{ $field }}" name="{{ $field }}"
                            placeholder="Enter one detail per line">{{ $details($field) }}</textarea>
                        <small class="help-text">
                            Enter each item on a separate line.
                        </small>
                    </div>
                </div>
            </section>
        @endforeach

        {{-- 7. PAYMENTS --}}
        <section class="form-section">
            <h3 class="section-title">7. Payment Details</h3>

            <div class="form-grid">
                <div class="form-field">
                    <label for="total_amount_display">Final Selling Price (₹)</label>
                    <input type="number" id="total_amount_display" value="{{ $value('total_amount', 0) }}"
                        readonly>
                    <small class="help-text">Read-only copy of the quotation total above.</small>
                </div>

                <div class="form-field">
                    <label for="advance_received">Advance Received (₹)</label>
                    <input type="number" id="advance_received" name="advance_received"
                        min="0" step="0.01" value="{{ $value('advance_received', 0) }}">
                </div>

                <div class="form-field">
                    <label for="payment_status">Payment Status <span class="required">*</span></label>
                    <select id="payment_status" name="payment_status" required>
                        @foreach (['Pending', 'Partially Paid', 'Paid', 'Refunded'] as $paymentStatus)
                            <option value="{{ $paymentStatus }}"
                                @selected($value('payment_status', 'Pending') === $paymentStatus)>
                                {{ $paymentStatus }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-field">
                    <label for="payment_mode">Payment Mode</label>
                    <select id="payment_mode" name="payment_mode">
                        @foreach (['', 'Cash', 'UPI', 'Bank Transfer', 'Card', 'Payment Gateway', 'Other'] as $mode)
                            <option value="{{ $mode }}"
                                @selected($value('payment_mode') === $mode)>
                                {{ $mode ?: 'Select payment mode' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-field">
                    <label for="last_payment_date">Last Payment Date</label>
                    <input type="date" id="last_payment_date" name="last_payment_date"
                        value="{{ $value('last_payment_date') instanceof \Carbon\Carbon ? $value('last_payment_date')->format('Y-m-d') : $value('last_payment_date') }}">
                </div>

                <div class="form-field">
                    <label for="balance_due_date">Balance Due Date</label>
                    <input type="date" id="balance_due_date" name="balance_due_date"
                        value="{{ $value('balance_due_date') instanceof \Carbon\Carbon ? $value('balance_due_date')->format('Y-m-d') : $value('balance_due_date') }}">
                </div>

                <div class="form-field">
                    <label for="payment_amount">New Payment Received (₹)</label>
                    <input type="number" id="payment_amount" name="payment_amount"
                        min="0" step="0.01" value="{{ old('payment_amount') }}">
                    <small class="help-text">Leave blank if you are not recording a new payment.</small>
                </div>

                <div class="form-field">
                    <label for="payment_date">New Payment Date</label>
                    <input type="date" id="payment_date" name="payment_date"
                        value="{{ old('payment_date') }}">
                </div>

                <div class="form-field">
                    <label for="payment_method">New Payment Method</label>
                    <select id="payment_method" name="payment_method">
                        @foreach (['', 'Cash', 'UPI', 'Bank Transfer', 'Card', 'Payment Gateway', 'Other'] as $method)
                            <option value="{{ $method }}"
                                @selected(old('payment_method') === $method)>
                                {{ $method ?: 'Select payment method' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-field full-width">
                    <label for="payment_note">Payment Note</label>
                    <textarea id="payment_note" name="payment_note"
                        placeholder="Reference number or payment remarks">{{ old('payment_note') }}</textarea>
                </div>

                @if ($editing && $record->payment_history)
                    <div class="form-field full-width">
                        <label>Previous Payment History</label>
                        <div class="history-list">
                            @foreach ($record->payment_history as $payment)
                                <div class="history-item">
                                    <strong>₹{{ number_format((float) ($payment['amount'] ?? 0), 2) }}</strong>
                                    <span>{{ $payment['date'] ?? 'Date not recorded' }}</span>
                                    <span>{{ $payment['method'] ?? 'Other' }}</span>
                                    @if (!empty($payment['note']))
                                        <p>{{ $payment['note'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>

        {{-- 8. DOCUMENTS --}}
        <section class="form-section">
            <h3 class="section-title">8. Travel Documents</h3>

            <div class="form-grid">
                <div class="form-field full-width">
                    <label for="documents">Upload Documents</label>
                    <input type="file" id="documents" name="documents[]" multiple
                        accept=".pdf,.jpg,.jpeg,.png,.webp,.doc,.docx">
                    <small class="help-text">
                        Allowed formats: PDF, JPG, PNG, WEBP, DOC and DOCX. Maximum 10 MB per file.
                    </small>
                </div>

                @if ($editing && $record->documents)
                    <div class="form-field full-width">
                        <label>Previously Uploaded Documents</label>

                        <div class="document-list">
                            @foreach ($record->documents as $document)
                                <div class="document-item">
                                    <span>{{ $document['name'] ?? 'Document' }}</span>
                                    <span class="help-text">
                                        {{ $document['uploaded_at'] ?? '' }}
                                    </span>
                                </div>
                            @endforeach
                        </div>

                        <small class="help-text">
                            Existing documents are retained when editing the record.
                        </small>
                    </div>
                @endif
            </div>
        </section>

        {{-- FORM ACTIONS --}}
        <div class="form-actions">
            <a href="{{ route('admin.travel-management.index') }}" class="btn-secondary">
                Cancel
            </a>

            <button type="submit" class="btn-primary">
                {{ $editing ? 'Update Travel Record' : 'Save Travel Record' }}
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const totalInput = document.getElementById('total_amount');
    const totalDisplay = document.getElementById('total_amount_display');

    function syncTotal() {
        if (totalInput && totalDisplay) {
            totalDisplay.value = totalInput.value || '0';
        }
    }

    if (totalInput) {
        totalInput.addEventListener('input', syncTotal);
        syncTotal();
    }
});
</script>
@endsection
