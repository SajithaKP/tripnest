<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('slug', 191)->unique();
            $t->string('destination');
            $t->string('category')->nullable();
            $t->string('short_description', 500)->nullable();
            $t->longText('description')->nullable();
            $t->string('duration')->nullable();
            $t->decimal('price', 12, 2);
            $t->decimal('old_price', 12, 2)->nullable();
            $t->string('featured_image')->nullable();
            $t->json('includes')->nullable();
            $t->json('excludes')->nullable();
            $t->boolean('featured')->default(false);
            $t->boolean('active')->default(true);
            $t->unsignedInteger('sort_order')->default(0);
            $t->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
