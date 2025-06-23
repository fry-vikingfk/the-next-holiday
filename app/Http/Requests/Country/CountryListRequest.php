<?php

namespace App\Http\Requests\Country;

use Illuminate\Foundation\Http\FormRequest;

class CountryListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'languageIsoCode' => ['nullable', 'string', 'max:2'],
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'languageIsoCode.string' => 'The language ISO code must be a string.',
            'languageIsoCode.max' => 'The language ISO code must not exceed 2 characters.',
            'languageIsoCode.nullable' => 'The language ISO code is optional.',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'languageIsoCode' => (string) strtoupper($this->input('languageIsoCode', '')),
        ]);
    }
}
