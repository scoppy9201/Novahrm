<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon', 50)->nullable();       // icon name để hiển thị UI
            $table->string('color', 20)->nullable();      // màu badge
            $table->boolean('requires_approval')->default(true);
            $table->boolean('requires_signature')->default(false);
            $table->enum('access_level', ['company', 'personal'])->default('personal');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_categories');
    }
};
