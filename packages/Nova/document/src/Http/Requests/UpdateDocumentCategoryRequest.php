<?php

namespace Nova\document\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'               => 'string|max:100',
            'icon'               => 'nullable|string',
            'color'              => 'nullable|string',
            'access_level'       => 'in:personal,company',
            'requires_approval'  => 'boolean',
            'requires_signature' => 'boolean',
            'order'              => 'integer',
        ];
    }
}