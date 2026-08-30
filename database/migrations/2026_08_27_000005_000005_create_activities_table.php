<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('location')->nullable();
            $t->text('description')->nullable();
            $t->string('image_path')->nullable();
            $t->string('icon')->nullable();
            $t->decimal('price', 12, 2)->nullable();
            $t->string('duration')->nullable();
            $t->boolean('active')->default(true);
            $t->unsignedInteger('sort_order')->default(0);
            $t->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
