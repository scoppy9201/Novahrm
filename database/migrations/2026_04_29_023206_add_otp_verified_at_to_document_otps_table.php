<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('document_otps', function (Blueprint $table) {
            $table->timestamp('otp_verified_at')->nullable()->after('expires_at');
        });
    }

    public function down(): void
    {
        Schema::table('document_otps', function (Blueprint $table) {
            $table->dropColumn('otp_verified_at');
        });
    }
};