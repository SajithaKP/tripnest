<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('resorts', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('location');
            $t->text('description')->nullable();
            $t->string('image_path')->nullable();
            $t->decimal('rating', 2, 1)->default(5);
            $t->decimal('price_from', 12, 2)->nullable();
            $t->json('amenities')->nullable();
            $t->boolean('active')->default(true);
            $t->unsignedInteger('sort_order')->default(0);
            $t->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('resorts');
    }
};
