<?php

namespace App\Http\Requests\System;

use Illuminate\Foundation\Http\FormRequest;

class SettingUpsertRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user('admin')?->can('manage-settings') ?? false;
    }
    public function rules(): array
    {
        return ['name' => 'required|string|max:190', 'val' => 'nullable'];
    }
}
