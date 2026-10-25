<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('travel_records', function (Blueprint $table) {
        $table->id();

        // Enquiry and customer
        $table->string('enquiry_number', 100)->unique();
        $table->string('booking_number', 100)->nullable()->unique();
        $table->dateTime('enquiry_at')->nullable();
        $table->string('customer_name', 200);
        $table->string('phone', 30);
        $table->string('email', 200)->nullable();
        $table->string('source', 100)->default('Website');
        $table->string('destination', 100)->nullable();
        $table->date('travel_date')->nullable();
        $table->date('return_date')->nullable();
        $table->unsignedInteger('adults')->default(1);
        $table->unsignedInteger('children')->default(0);
        $table->unsignedInteger('infants')->default(0);
        $table->decimal('budget', 12, 2)->nullable();
        $table->text('requirements')->nullable();

        // Enquiry and follow-up
        $table->string('status', 50)->default('New Enquiry');
        $table->dateTime('follow_up_at')->nullable();
        $table->text('follow_up_notes')->nullable();

        // Quotation and costing
        $table->string('package_name', 200)->nullable();
        $table->string('duration', 100)->nullable();
        $table->decimal('adult_rate', 12, 2)->default(0);
        $table->decimal('child_rate', 12, 2)->default(0);
        $table->decimal('flight_cost', 12, 2)->default(0);
        $table->decimal('accommodation_cost', 12, 2)->default(0);
        $table->decimal('transfer_cost', 12, 2)->default(0);
        $table->decimal('activities_cost', 12, 2)->default(0);
        $table->decimal('permit_cost', 12, 2)->default(0);
        $table->decimal('other_charges', 12, 2)->default(0);
        $table->decimal('agency_margin', 12, 2)->default(0);
        $table->decimal('total_amount', 12, 2)->default(0);
        $table->longText('inclusions')->nullable();
        $table->longText('exclusions')->nullable();

        // Travel arrangements (first-version flexible details)
        $table->json('flight_details')->nullable();
        $table->json('hotel_details')->nullable();
        $table->json('operations_details')->nullable();
        $table->json('permit_details')->nullable();

        // Payments
        $table->decimal('advance_received', 12, 2)->default(0);
        $table->date('last_payment_date')->nullable();
        $table->string('payment_mode', 100)->nullable();
        $table->date('balance_due_date')->nullable();
        $table->string('payment_status')->default('Pending');
        $table->json('payment_history')->nullable();

        // Document paths
        $table->json('documents')->nullable();

        $table->timestamps();

        $table->index(['status', 'travel_date']);
        $table->index(['source', 'enquiry_at']);
        $table->index('customer_name');
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_records');
    }
};
