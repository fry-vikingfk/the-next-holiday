<?php

namespace App\Http\Requests\Country;

use Illuminate\Foundation\Http\FormRequest;

class CountryListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'languageIsoCode' => ['nullable', 'string', 'max:2'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'languageIsoCode' => (string) strtoupper($this->input('languageIsoCode', '')),
        ]);
    }
}
