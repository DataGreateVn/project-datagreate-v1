<?php

namespace App\Http\Requests\System;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TranslationUpsertRequest extends FormRequest
{
    public function authorize(): bool
    {
        // đổi lại nếu bạn dùng tên quyền khác, ví dụ: translations.manage
        return $this->user('admin')?->can('manage-translations') ?? false;
    }

    public function rules(): array
    {
        $id  = $this->route('translation')?->id; // model binding khi update
        $ns  = $this->input('namespace') ?? '*';
        $grp = $this->input('group') ?? '*';

        return [
            'locale'    => ['required', 'string', 'max:10'],
            'namespace' => ['nullable', 'string', 'max:50'],
            'group'     => ['required', 'string', 'max:100'],
            'key'       => [
                'required',
                'string',
                'max:191',
                Rule::unique('translations')->ignore($id)->where(function ($q) use ($ns, $grp) {
                    return $q->where('locale', request('locale'))
                        ->where('namespace', $ns ?: '*')
                        ->where('group', $grp ?: '*');
                }),
            ],
            'value'     => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'namespace' => $this->input('namespace') ?: '*',
        ]);
    }
}
