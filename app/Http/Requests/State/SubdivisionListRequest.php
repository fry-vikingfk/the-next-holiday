<?php

namespace App\Http\Requests\State;

use Illuminate\Foundation\Http\FormRequest;

class SubdivisionListRequest extends FormRequest
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
            'countryIsoCode' => ['required', 'string', 'size:2'],
            'languageIsoCode' => ['nullable', 'string', 'size:2'],
        ];
    }
}
