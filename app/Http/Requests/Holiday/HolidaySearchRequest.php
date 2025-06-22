<?php

namespace App\Http\Requests\Holiday;

use Carbon\Carbon;
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
            'languageIsoCode' => ['sometimes', 'string', 'regex:/^[A-Z]{2}$/'],
            'validFrom' => ['sometimes', 'date:Y-m-d'],
            'validTo' => ['sometimes', 'date:Y-m-d'],
        ];
    }

    
    protected function prepareForValidation(): void
    {
        $languageIsoCode = strtoupper($this->input('languageIsoCode', 'en'));
        $countryIsoCode = strtoupper($this->input('countryIsoCode', 'DE'));
        $subdivisionCode = strtoupper($this->input('subdivisionCode', ''));
        $startDate = $this->input('validFrom', Carbon::now()->toDateString());
        $endDate = $this->input('validTo', Carbon::now()->endOfYear()->toDateString());

        $this->merge([
            'languageIsoCode' => $languageIsoCode,
            'countryIsoCode' => $countryIsoCode,
            'subdivisionCode' => $subdivisionCode,
            'validFrom' => $startDate,
            'validTo' => $endDate,
        ]);
    }
}
