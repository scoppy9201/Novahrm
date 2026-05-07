<?php

namespace Nova\Profile\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name'     => ['required', 'string', 'max:100', 'regex:/^[\p{L}\s]+$/u'],
            'last_name'      => ['required', 'string', 'max:100', 'regex:/^[\p{L}\s]+$/u'],
            'phone'          => ['nullable', 'regex:/^(\+84|0)\d{9}$/'],
            'date_of_birth'  => ['nullable', 'date', 'before:' . now()->subYears(18)->format('Y-m-d')],
            'gender'         => ['nullable', 'in:male,female,other'],
            'address'        => ['nullable', 'string', 'max:255'],
            'language'       => ['nullable', 'in:vi,en'],
            'job_title'      => ['nullable', 'string', 'max:100'],
            'occupation'     => ['nullable', 'string', 'max:100'],
            'department_id'  => ['nullable', 'integer', 'exists:departments,id'],
            'office_id'      => ['nullable', 'integer', 'exists:offices,id'],
            'position_id'    => ['nullable', 'integer', 'exists:positions,id'],
            'manager_id'     => ['nullable', 'integer', 'exists:employees,id'],
            'email_personal' => ['nullable', 'email', 'max:255', 'regex:/^[^@]+@gmail\.com$/i'],
            'bio'            => ['nullable', 'string', 'max:1000'],
            'avatar'         => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'hire_date'      => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required'  => 'Vui lòng nhập họ.',
            'first_name.regex'     => 'Họ không được chứa số hoặc ký tự đặc biệt.',
            'last_name.required'   => 'Vui lòng nhập tên.',
            'last_name.regex'      => 'Tên không được chứa số hoặc ký tự đặc biệt.',
            'phone.regex'          => 'Số điện thoại phải có 10 chữ số, bắt đầu bằng 0 hoặc +84.',
            'date_of_birth.before' => 'Bạn phải đủ 18 tuổi.',
            'date_of_birth.date'   => 'Ngày sinh không hợp lệ.',
            'email_personal.email' => 'Email cá nhân không hợp lệ.',
            'email_personal.regex' => 'Email cá nhân phải có đuôi @gmail.com.',
            'avatar.file'          => 'File phải là ảnh.',
            'avatar.max'           => 'Ảnh không được vượt quá 2MB.',
        ];
    }
}