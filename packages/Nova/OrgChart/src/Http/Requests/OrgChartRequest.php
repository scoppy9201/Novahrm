<?php

namespace Nova\OrgChart\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrgChartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $departmentId = $this->route('department')?->id;

        return [
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('departments')
                    ->where(fn($q) => $q->where('parent_id', $this->parent_id))
                    ->ignore($departmentId),
            ],
            'code'        => ['nullable', 'string', 'max:50', Rule::unique('departments', 'code')->ignore($departmentId)],
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|integer|exists:departments,id',
            'manager_id'  => 'nullable|integer|exists:employees,id',
            'color'       => 'nullable|string|max:20',
            'order'       => 'nullable|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Tên phòng ban đã tồn tại trong cùng cấp này.',
            'code.unique' => 'Mã phòng ban đã được sử dụng.',
        ];
    }
}