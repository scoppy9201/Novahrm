<?php

namespace Nova\Profile\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string'],
            'password'         => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'password.required'         => 'Vui lòng nhập mật khẩu mới.',
            'password.confirmed'        => 'Xác nhận mật khẩu không khớp.',
            'password.min'              => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'password.mixed_case'       => 'Mật khẩu phải chứa cả chữ hoa và chữ thường.',
            'password.numbers'          => 'Mật khẩu phải chứa ít nhất một chữ số.',
        ];
    }
}