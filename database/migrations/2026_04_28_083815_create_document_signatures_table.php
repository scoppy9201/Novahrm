<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_signatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')
                  ->constrained('documents')
                  ->cascadeOnDelete();
            $table->foreignId('employee_id')
                  ->constrained('employees')
                  ->restrictOnDelete();

            $table->text('signature_image');              // base64 PNG chữ ký tay
            $table->string('ip_address', 45);            // IPv4 + IPv6
            $table->string('user_agent')->nullable();
            $table->string('otp', 10);                   // OTP đã dùng (hashed)
            $table->timestamp('otp_sent_at')->nullable();
            $table->timestamp('otp_verified_at')->nullable();
            $table->timestamp('signed_at');

            // Vị trí nhúng chữ ký vào PDF
            $table->integer('page_number')->default(1);
            $table->decimal('pos_x', 8, 2)->nullable();
            $table->decimal('pos_y', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_signatures');
    }
};
