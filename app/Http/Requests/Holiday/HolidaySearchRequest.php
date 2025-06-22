<?php

namespace App\Http\Requests\Holiday;

use App\Enums\HolidayTypeEnum;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;

class HolidaySearchRequest extends FormRequest
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
            'countryIsoCode' => ['sometimes', 'string' , 'regex:/^[A-Z]{2}$/'],
            'subdivisionCode' => ['sometimes', 'string', 'regex:/^[A-Z]{2}(?:-[A-Z]{2})?(?:-[A-Z]{2})?$/'],
            'type' => ['sometimes', 'string', Rule::in(HolidayTypeEnum::values())],
            'languageIsoCode' => ['sometimes', 'string', 'regex:/^[A-Z]{2}$/'],
            'startDate' => ['sometimes', 'date:Y-m-d'],
            'endDate' => ['sometimes', 'date:Y-m-d'],
        ];
    }

    
    protected function prepareForValidation(): void
    {
        $languageIsoCode = strtoupper($this->input('languageIsoCode', 'en'));
        $countryIsoCode = strtoupper($this->input('countryIsoCode', 'DE'));
        $subdivisionCode = strtoupper($this->input('subdivisionCode', ''));

        $this->merge([
            'languageIsoCode' => $languageIsoCode,
            'countryIsoCode' => $countryIsoCode,
            'subdivisionCode' => $subdivisionCode,
        ]);
    }
}
