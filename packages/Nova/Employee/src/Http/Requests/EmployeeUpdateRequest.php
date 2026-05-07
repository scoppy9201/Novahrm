<?php

namespace Nova\Employee\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Nova\Auth\Models\Employee;

class EmployeeUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('employee')?->id;

        return [
            'first_name'                  => 'required|string|max:100',
            'last_name'                   => 'required|string|max:100',
            'gender'                      => 'nullable|in:male,female,other',
            'date_of_birth'               => 'nullable|date|before:today',
            'place_of_birth'              => 'nullable|string|max:255',
            'nationality'                 => 'nullable|string|max:100',
            'ethnicity'                   => 'nullable|string|max:100',
            'religion'                    => 'nullable|string|max:100',
            'national_id'                 => 'nullable|string|max:20|unique:employees,national_id,' . $id,
            'national_id_issued_date'     => 'nullable|date',
            'national_id_issued_place'    => 'nullable|string|max:255',
            'passport_number'             => 'nullable|string|max:30',
            'passport_expiry_date'        => 'nullable|date',
            'email'                       => 'nullable|email|unique:employees,email,' . $id,
            'work_email'                  => 'nullable|email|unique:employees,work_email,' . $id,
            'phone'                       => 'nullable|string|max:20',
            'phone_alt'                   => 'nullable|string|max:20',
            'emergency_contact_name'      => 'nullable|string|max:255',
            'emergency_contact_phone'     => 'nullable|string|max:20',
            'emergency_contact_relation'  => 'nullable|string|max:100',
            'permanent_address'           => 'nullable|string|max:255',
            'permanent_ward'              => 'nullable|string|max:100',
            'permanent_district'          => 'nullable|string|max:100',
            'permanent_province'          => 'nullable|string|max:100',
            'current_address'             => 'nullable|string|max:255',
            'current_ward'                => 'nullable|string|max:100',
            'current_district'            => 'nullable|string|max:100',
            'current_province'            => 'nullable|string|max:100',
            'department_id'               => 'nullable|exists:departments,id',
            'position_id'                 => 'nullable|exists:positions,id',
            'manager_id'                  => 'nullable|exists:employees,id|different:id',
            'employment_type'             => 'required|in:' . implode(',', array_keys(Employee::EMPLOYMENT_TYPES)),
            'hire_date'                   => 'nullable|date',
            'probation_start_date'        => 'nullable|date',
            'probation_end_date'          => 'nullable|date|after_or_equal:probation_start_date',
            'official_start_date'         => 'nullable|date',
            'contract_type'               => 'nullable|in:' . implode(',', array_keys(Employee::CONTRACT_TYPES)),
            'contract_number'             => 'nullable|string|max:100',
            'contract_start_date'         => 'nullable|date',
            'contract_end_date'           => 'nullable|date|after_or_equal:contract_start_date',
            'basic_salary'                => 'nullable|integer|min:0',
            'salary_type'                 => 'nullable|in:monthly,daily,hourly',
            'bank_name'                   => 'nullable|string|max:100',
            'bank_account'                => 'nullable|string|max:50',
            'bank_branch'                 => 'nullable|string|max:150',
            'bank_account_name'           => 'nullable|string|max:150',
            'tax_code'                    => 'nullable|string|max:20|unique:employees,tax_code,' . $id,
            'social_insurance_code'       => 'nullable|string|max:20|unique:employees,social_insurance_code,' . $id,
            'health_insurance_code'       => 'nullable|string|max:20',
            'health_insurance_place'      => 'nullable|string|max:255',
            'social_insurance_start_date' => 'nullable|date',
            'education_level'             => 'nullable|in:' . implode(',', array_keys(Employee::EDUCATION_LEVELS)),
            'education_major'             => 'nullable|string|max:255',
            'education_school'            => 'nullable|string|max:255',
            'status'                      => 'nullable|in:' . implode(',', array_keys(Employee::STATUSES)),
            'is_active'                   => 'boolean',
            'avatar'                      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'cv_path'                     => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'notes'                       => 'nullable|string',
            'bio'                         => 'nullable|string',
        ];
    }
}