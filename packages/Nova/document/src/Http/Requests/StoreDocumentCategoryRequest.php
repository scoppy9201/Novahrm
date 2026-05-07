<?php

namespace Nova\document\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'               => 'required|string|max:100',
            'slug'               => 'required|string|unique:document_categories,slug',
            'icon'               => 'nullable|string',
            'color'              => 'nullable|string',
            'access_level'       => 'required|in:personal,company',
            'requires_approval'  => 'boolean',
            'requires_signature' => 'boolean',
            'order'              => 'integer',
            'is_active'          => 'boolean',
        ];
    }
}