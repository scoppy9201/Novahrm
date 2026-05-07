<?php

namespace Nova\document\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'           => 'required|string|max:255',
            'file'            => 'required|file|mimes:pdf|max:20480',
            'category_id'     => 'required|exists:document_categories,id',
            'employee_id'     => 'nullable|exists:employees,id',
            'tags'            => 'nullable|array',
            'is_confidential' => 'boolean',
            'issued_at'       => 'nullable|date',
            'expires_at'      => 'nullable|date|after:issued_at',
        ];
    }
}