<?php

namespace Nova\Profile\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'notif_attendance' => ['required', 'in:all,daily,none'],
            'notif_payroll'    => ['required', 'in:monthly,none'],
        ];
    }

    public function messages(): array
    {
        return [
            'notif_attendance.required' => 'Vui lòng chọn cài đặt thông báo chấm công.',
            'notif_attendance.in'       => 'Giá trị thông báo chấm công không hợp lệ.',
            'notif_payroll.required'    => 'Vui lòng chọn cài đặt thông báo lương.',
            'notif_payroll.in'          => 'Giá trị thông báo lương không hợp lệ.',
        ];
    }
}