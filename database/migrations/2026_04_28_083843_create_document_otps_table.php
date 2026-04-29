<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_otps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')
                  ->constrained('documents')
                  ->cascadeOnDelete();
            $table->foreignId('employee_id')
                  ->constrained('employees')
                  ->cascadeOnDelete();
            $table->string('otp', 10);                   // plain, chỉ lưu ngắn
            $table->timestamp('expires_at');              // hết hạn sau 10 phút
            $table->boolean('is_used')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_otps');
    }
};
