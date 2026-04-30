<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->enum('status', ['active', 'inactive'])
                  ->default('active')
                  ->after('color');

            $table->softDeletes()->after('updated_at');

            $table->index('status');
        });

        Schema::table('positions', function (Blueprint $table) {
            $table->enum('level', [
                'intern',
                'junior',
                'mid',
                'senior',
                'lead',
                'manager',
                'director',
            ])->nullable()->after('description');

            $table->decimal('salary_min', 15, 2)
                  ->nullable()
                  ->after('salary');

            $table->decimal('salary_max', 15, 2)
                  ->nullable()
                  ->after('salary_min');

            $table->unsignedInteger('headcount_plan')
                  ->default(0)
                  ->after('salary_max');

            $table->enum('status', ['active', 'inactive'])
                  ->default('active')
                  ->after('headcount_plan');

            $table->softDeletes()->after('updated_at');

            $table->index('status');
            $table->index('level');
        });
    }

    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropColumn(['status', 'deleted_at']);
        });

        Schema::table('positions', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['level']);
            $table->dropColumn([
                'level',
                'salary_min',
                'salary_max',
                'headcount_plan',
                'status',
                'deleted_at',
            ]);
        });
    }
};