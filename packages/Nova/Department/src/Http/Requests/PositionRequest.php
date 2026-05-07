<?php

namespace Nova\Department\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Nova\Department\Models\Position;

class PositionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->position?->id;

        return [
            'title'          => 'required|string|max:255',
            'code'           => 'required|string|max:50|unique:positions,code,' . $id,
            'description'    => 'nullable|string',
            'department_id'  => 'required|exists:departments,id',
            'level'          => 'nullable|in:' . implode(',', array_keys(Position::LEVELS)),
            'salary_min'     => 'nullable|numeric|min:0',
            'salary_max'     => 'nullable|numeric|min:0|gte:salary_min',
            'headcount_plan' => 'nullable|integer|min:0',
            'status'         => 'required|in:active,inactive',
        ];
    }
}