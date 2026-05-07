<?php

namespace Nova\Employee\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Nova\Auth\Models\Employee;

class EmployeeStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name'                  => 'required|string|max:100',
            'last_name'                   => 'required|string|max:100',
            'gender'                      => 'nullable|in:male,female,other',
            'date_of_birth'               => 'nullable|date|before:today',
            'place_of_birth'              => 'nullable|string|max:255',
            'nationality'                 => 'nullable|string|max:100',
            'ethnicity'                   => 'nullable|string|max:100',
            'religion'                    => 'nullable|string|max:100',
            'national_id'                 => 'nullable|digits:12|unique:employees,national_id',
            'national_id_issued_date'     => 'nullable|date',
            'national_id_issued_place'    => 'nullable|string|max:255',
            'passport_number'             => 'nullable|string|min:6|max:20|regex:/^[A-Z0-9]+$/i',
            'passport_expiry_date'        => 'nullable|date',
            'email'                       => 'nullable|email|regex:/^[a-zA-Z0-9._]+@gmail\.com$/|unique:employees,email',
            'work_email'                  => 'nullable|email|regex:/^[a-zA-Z0-9._]+@gmail\.com$/|unique:employees,work_email',
            'phone'                       => 'nullable|regex:/^0[0-9]{9}$/',
            'phone_alt'                   => 'nullable|regex:/^0[0-9]{9}$/',
            'emergency_contact_name'      => 'nullable|string|max:255',
            'emergency_contact_phone'     => 'nullable|regex:/^0[0-9]{9}$/',
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
            'manager_id'                  => 'nullable|exists:employees,id',
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
            'tax_code'                    => 'nullable|string|max:20|unique:employees,tax_code',
            'social_insurance_code'       => 'nullable|string|max:20|unique:employees,social_insurance_code',
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

    public function messages(): array
    {
        return [
            'first_name.required'               => 'Vui lòng nhập họ của nhân viên.',
            'last_name.required'                => 'Vui lòng nhập tên của nhân viên.',
            'employment_type.required'          => 'Vui lòng chọn loại nhân viên.',
            'national_id.digits'                => 'Số CCCD phải đúng 12 chữ số.',
            'national_id.unique'                => 'Số CCCD này đã tồn tại trong hệ thống.',
            'passport_number.regex'             => 'Số hộ chiếu chỉ được chứa chữ cái và chữ số.',
            'email.regex'                       => 'Email cá nhân phải có đuôi @gmail.com.',
            'email.unique'                      => 'Email cá nhân này đã được sử dụng.',
            'work_email.regex'                  => 'Email công ty phải có đuôi @gmail.com.',
            'work_email.unique'                 => 'Email công ty này đã được sử dụng.',
            'phone.regex'                       => 'Số điện thoại phải bắt đầu bằng 0 và đủ 10 chữ số.',
            'phone_alt.regex'                   => 'SĐT phụ phải bắt đầu bằng 0 và đủ 10 chữ số.',
            'emergency_contact_phone.regex'     => 'SĐT khẩn cấp phải bắt đầu bằng 0 và đủ 10 chữ số.',
            'date_of_birth.before'              => 'Ngày sinh không hợp lệ.',
            'probation_end_date.after_or_equal' => 'Ngày kết thúc thử việc phải sau ngày bắt đầu.',
            'contract_end_date.after_or_equal'  => 'Ngày kết thúc hợp đồng phải sau ngày bắt đầu.',
            'tax_code.unique'                   => 'Mã số thuế này đã tồn tại.',
            'social_insurance_code.unique'      => 'Mã BHXH này đã tồn tại.',
            'avatar.max'                        => 'Ảnh đại diện không được vượt quá 2MB.',
            'cv_path.max'                       => 'File CV không được vượt quá 5MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(
            collect($this->all())
                ->map(fn($v) => $v === '' ? null : $v)
                ->toArray()
        );
    }
}