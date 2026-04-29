<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')
                  ->constrained('documents')
                  ->cascadeOnDelete();
            $table->foreignId('actor_id')                // manager thực hiện
                  ->constrained('employees')
                  ->restrictOnDelete();
            $table->enum('action', ['submitted', 'approved', 'rejected', 'revision_requested']);
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_approvals');
    }
};
