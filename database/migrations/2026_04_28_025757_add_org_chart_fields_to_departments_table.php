<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->foreignId('parent_id')
                ->nullable()
                ->after('description')
                ->constrained('departments')
                ->nullOnDelete();

            $table->integer('order')->default(0)->after('parent_id');
            $table->string('color', 20)->nullable()->after('order');
        });
    }

    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['parent_id', 'order', 'color']);
        });
    }
};
