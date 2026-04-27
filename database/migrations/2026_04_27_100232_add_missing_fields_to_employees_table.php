<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('job_title')->nullable()->after('avatar');
            $table->string('occupation')->nullable()->after('job_title');
            $table->string('office')->nullable()->after('occupation');
            $table->unsignedBigInteger('office_id')->nullable()->after('office');
            $table->unsignedBigInteger('manager_id')->nullable()->after('office_id');
            $table->string('email_personal')->nullable()->after('manager_id');
            $table->text('bio')->nullable()->after('email_personal');
            $table->string('role')->nullable()->after('bio');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'job_title', 'occupation', 'office', 'office_id',
                'manager_id', 'email_personal', 'bio', 'role',
            ]);
        });
    }
};
