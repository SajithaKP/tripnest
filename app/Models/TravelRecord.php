<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelRecord extends Model
{
    protected $fillable = [
        'enquiry_number',
        'booking_number',
        'enquiry_at',
        'customer_name',
        'phone',
        'email',
        'source',
        'destination',
        'travel_date',
        'return_date',
        'adults',
        'children',
        'infants',
        'budget',
        'requirements',
        'status',
        'follow_up_at',
        'follow_up_notes',
        'package_name',
        'duration',
        'adult_rate',
        'child_rate',
        'flight_cost',
        'accommodation_cost',
        'transfer_cost',
        'activities_cost',
        'permit_cost',
        'other_charges',
        'agency_margin',
        'total_amount',
        'inclusions',
        'exclusions',
        'flight_details',
        'hotel_details',
        'operations_details',
        'permit_details',
        'advance_received',
        'last_payment_date',
        'payment_mode',
        'balance_due_date',
        'payment_status',
        'payment_history',
        'documents',
    ];

    protected function casts(): array
    {
        return [
            'enquiry_at' => 'datetime',
            'travel_date' => 'date',
            'return_date' => 'date',
            'follow_up_at' => 'datetime',
            'last_payment_date' => 'date',
            'balance_due_date' => 'date',
            'flight_details' => 'array',
            'hotel_details' => 'array',
            'operations_details' => 'array',
            'permit_details' => 'array',
            'payment_history' => 'array',
            'documents' => 'array',
            'budget' => 'decimal:2',
            'adult_rate' => 'decimal:2',
            'child_rate' => 'decimal:2',
            'flight_cost' => 'decimal:2',
            'accommodation_cost' => 'decimal:2',
            'transfer_cost' => 'decimal:2',
            'activities_cost' => 'decimal:2',
            'permit_cost' => 'decimal:2',
            'other_charges' => 'decimal:2',
            'agency_margin' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'advance_received' => 'decimal:2',
        ];
    }

    public function getBalanceAmountAttribute(): float
    {
        return max(
            0,
            (float) $this->total_amount - (float) $this->advance_received
        );
    }
}