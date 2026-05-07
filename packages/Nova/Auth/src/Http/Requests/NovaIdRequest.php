<?php

namespace Nova\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NovaIdRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255'],
            'type'  => ['required', 'in:magic_link,otp'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Vui lòng nhập email.',
            'email.email'    => 'Email không hợp lệ.',
            'type.in'        => 'Loại xác thực không hợp lệ.',
        ];
    }
}