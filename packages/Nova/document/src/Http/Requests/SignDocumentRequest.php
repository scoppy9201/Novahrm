<?php

namespace Nova\document\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'otp'             => 'required|string|size:6',
            'signature_image' => 'required|string',
            'page_number'     => 'required|integer|min:1',
            'pos_x'           => 'required|numeric',
            'pos_y'           => 'required|numeric',
            'width'           => 'nullable|numeric',
            'height'          => 'nullable|numeric',
        ];
    }
}