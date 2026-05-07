<?php

namespace Nova\Department\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->department?->id;

        return [
            'name'        => 'required|string|max:255',
            'code'        => 'required|string|max:50|unique:departments,code,' . $id,
            'description' => 'nullable|string',
            'parent_id'   => 'nullable|exists:departments,id',
            'manager_id'  => 'nullable|exists:employees,id',
            'color'       => 'nullable|string|max:7',
            'order'       => 'nullable|integer|min:0',
            'status'      => 'required|in:active,inactive',
        ];
    }
}