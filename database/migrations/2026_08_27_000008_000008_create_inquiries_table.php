<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('email');
            $t->string('phone');
            $t->date('travel_date')->nullable();
            $t->unsignedInteger('travellers')->nullable();
            $t->string('package_name')->nullable();
            $t->text('message')->nullable();
            $t->enum('status', ['new', 'contacted', 'closed'])->default('new');
            $t->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
