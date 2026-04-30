<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {

            // Thông tin cá nhân bổ sung
            $table->string('place_of_birth')->nullable()->after('date_of_birth');
            $table->string('nationality', 100)->default('Việt Nam')->after('place_of_birth');
            $table->string('ethnicity', 100)->nullable()->after('nationality');
            $table->string('religion', 100)->nullable()->after('ethnicity');
            $table->date('national_id_issued_date')->nullable()->after('national_id');
            $table->string('national_id_issued_place')->nullable()->after('national_id_issued_date');
            $table->string('passport_number', 30)->nullable()->after('national_id_issued_place');
            $table->date('passport_expiry_date')->nullable()->after('passport_number');

            // Liên hệ bổ sung
            $table->string('work_email')->nullable()->after('email_personal');
            $table->string('phone_alt', 20)->nullable()->after('phone');
            $table->string('emergency_contact_relation')->nullable()->after('emergency_contact_phone');

            // Địa chỉ chi tiết
            $table->string('permanent_address')->nullable()->after('address');
            $table->string('permanent_ward')->nullable()->after('permanent_address');
            $table->string('permanent_district')->nullable()->after('permanent_ward');
            $table->string('permanent_province')->nullable()->after('permanent_district');
            $table->string('current_address')->nullable()->after('permanent_province');
            $table->string('current_ward')->nullable()->after('current_address');
            $table->string('current_district')->nullable()->after('current_ward');
            $table->string('current_province')->nullable()->after('current_district');

            // Công việc bổ sung
            $table->date('probation_start_date')->nullable()->after('hire_date');
            $table->date('probation_end_date')->nullable()->after('probation_start_date');
            $table->date('official_start_date')->nullable()->after('probation_end_date');

            // Hợp đồng
            $table->enum('contract_type', [
                'indefinite', 'fixed_term_1y', 'fixed_term_2y',
                'fixed_term_3y', 'seasonal', 'probation', 'internship',
            ])->nullable()->after('employment_type');
            $table->string('contract_number', 100)->nullable()->after('contract_type');
            $table->date('contract_start_date')->nullable()->after('contract_number');
            $table->date('contract_end_date')->nullable()->after('contract_start_date');
            $table->unsignedTinyInteger('contract_renewal_count')->default(0)->after('contract_end_date');

            // Lương & tài chính
            $table->unsignedBigInteger('basic_salary')->default(0)->after('termination_date');
            $table->enum('salary_type', ['monthly', 'daily', 'hourly'])->default('monthly')->after('basic_salary');
            $table->string('bank_name', 100)->nullable()->after('salary_type');
            $table->string('bank_account', 50)->nullable()->after('bank_name');
            $table->string('bank_branch', 150)->nullable()->after('bank_account');
            $table->string('bank_account_name', 150)->nullable()->after('bank_branch');
            $table->string('tax_code', 20)->nullable()->after('bank_account_name');
            $table->string('social_insurance_code', 20)->nullable()->after('tax_code');
            $table->string('health_insurance_code', 20)->nullable()->after('social_insurance_code');
            $table->string('health_insurance_place')->nullable()->after('health_insurance_code');
            $table->date('social_insurance_start_date')->nullable()->after('health_insurance_place');

            // Học vấn
            $table->enum('education_level', [
                'none', 'primary', 'secondary', 'high_school',
                'college', 'bachelor', 'master', 'phd',
            ])->nullable()->after('social_insurance_start_date');
            $table->string('education_major')->nullable()->after('education_level');
            $table->string('education_school')->nullable()->after('education_major');

            // Trạng thái mở rộng
            $table->enum('status', [
                'active', 'probation', 'on_leave', 'maternity_leave',
                'paternity_leave', 'sick_leave', 'suspended',
                'resigned', 'terminated', 'retired', 'deceased',
            ])->default('active')->after('is_active');
            $table->string('termination_reason')->nullable()->after('termination_date');
            $table->enum('termination_type', [
                'voluntary', 'involuntary', 'retirement',
                'end_of_contract', 'deceased',
            ])->nullable()->after('termination_reason');

            // Media & misc
            $table->string('cv_path')->nullable()->after('avatar');
            $table->string('signature_path')->nullable()->after('cv_path');
            $table->json('meta')->nullable()->after('bio');

            // Indexes
            $table->index('status');
            $table->index('contract_end_date');
            $table->index('probation_end_date');
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'place_of_birth', 'nationality', 'ethnicity', 'religion',
                'national_id_issued_date', 'national_id_issued_place',
                'passport_number', 'passport_expiry_date',
                'work_email', 'phone_alt', 'emergency_contact_relation',
                'permanent_address', 'permanent_ward', 'permanent_district', 'permanent_province',
                'current_address', 'current_ward', 'current_district', 'current_province',
                'probation_start_date', 'probation_end_date', 'official_start_date',
                'contract_type', 'contract_number', 'contract_start_date',
                'contract_end_date', 'contract_renewal_count',
                'basic_salary', 'salary_type',
                'bank_name', 'bank_account', 'bank_branch', 'bank_account_name',
                'tax_code', 'social_insurance_code', 'health_insurance_code',
                'health_insurance_place', 'social_insurance_start_date',
                'education_level', 'education_major', 'education_school',
                'status', 'termination_reason', 'termination_type',
                'cv_path', 'signature_path', 'meta',
            ]);
        });
    }
};
