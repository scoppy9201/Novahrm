<?php

namespace Nova\document\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        if ($this->has('tags') && is_string($this->tags)) {
            $this->merge([
                'tags' => json_decode($this->tags, true) ?? [],
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'file_name'       => 'nullable|string',
            'category_id'     => 'nullable|exists:document_categories,id',
            'employee_id'     => 'nullable|exists:employees,id',
            'tags'            => 'nullable|array',
            'is_confidential' => 'boolean',
            'issued_at'       => 'nullable|date',
            'expires_at'      => 'nullable|date',
            'version'         => 'nullable|integer|min:1',
        ];
    }
}