<?php

namespace App\Http\Requests\SystemSystem;

use Illuminate\Foundation\Http\FormRequest;

class TranslationUpsertRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'locale'    => ['required','string'],
            'namespace' => ['nullable','string'],
            'group'     => ['required','string'],
            'key'       => ['required','string'],
            'value'     => ['nullable','string'],
        ];
    }
}
