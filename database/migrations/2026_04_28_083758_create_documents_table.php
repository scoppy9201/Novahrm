<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                  ->constrained('document_categories')
                  ->restrictOnDelete();

            $table->string('title');
            $table->text('description')->nullable();

            // File
            $table->string('file_path');                  // file gốc
            $table->string('file_name');                  // tên gốc để hiển thị
            $table->string('file_mime', 100);             // application/pdf...
            $table->unsignedBigInteger('file_size');      // bytes
            $table->string('signed_file_path')->nullable(); // file sau khi ký

            // Liên kết nhân viên
            $table->foreignId('uploaded_by')
                  ->constrained('employees')
                  ->restrictOnDelete();

            $table->foreignId('employee_id')              // null = tài liệu công ty
                  ->nullable()
                  ->constrained('employees')
                  ->nullOnDelete();

            // Trạng thái
            $table->enum('status', [
                'draft',      // nháp
                'pending',    // chờ duyệt
                'approved',   // đã duyệt
                'rejected',   // từ chối
                'signing',    // đang chờ ký
                'signed',     // đã ký
                'expired',    // hết hạn
            ])->default('draft');

            // Phê duyệt
            $table->foreignId('approved_by')
                  ->nullable()
                  ->constrained('employees')
                  ->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();

            // Thời hạn
            $table->date('issued_at')->nullable();        // ngày ban hành
            $table->date('expires_at')->nullable();       // ngày hết hạn

            // Metadata
            $table->json('tags')->nullable();             // ['hợp đồng', 'thử việc']
            $table->boolean('is_confidential')->default(false); // tài liệu mật
            $table->integer('version')->default(1);       // version tài liệu

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
