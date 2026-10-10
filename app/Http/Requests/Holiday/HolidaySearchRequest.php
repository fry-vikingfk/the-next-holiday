<?php

namespace App\Http\Requests\Holiday;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class HolidaySearchRequest extends FormRequest
{
    public const DEFAULT_LANGUAGE = 'en';

    public const DEFAULT_COUNTRY = 'IE';

    public const DEFAULT_SUBDIVISION = '';

    public const DEFAULT_PER_PAGE = 4;

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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'countryIsoCode' => ['sometimes', 'string', 'regex:/^[A-Z]{2}$/'],
            'subdivisionCode' => ['sometimes', 'string', 'regex:/^[A-Z]{2}(?:-[A-Z]{2})?(?:-[A-Z]{2})?$/'],
            'languageIsoCode' => ['sometimes', 'string', 'regex:/^[A-Z]{2}$/'],
            'validFrom' => ['sometimes', 'date:Y-m-d'],
            'validTo' => ['sometimes', 'date:Y-m-d'],
            'page' => ['sometimes', 'integer', 'min:1'],
            'perPage' => ['sometimes', 'integer', 'min:1', 'max:100'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'languageIsoCode' => strtoupper($this->input('languageIsoCode', self::DEFAULT_LANGUAGE)),
            'countryIsoCode' => strtoupper($this->input('countryIsoCode', self::DEFAULT_COUNTRY)),
            'subdivisionCode' => strtoupper($this->input('subdivisionCode', self::DEFAULT_SUBDIVISION)),
            'validFrom' => $this->input('validFrom', Carbon::now()->toDateString()),
            'validTo' => $this->input('validTo', Carbon::now()->addMonth(6)->toDateString()),
            'page' => (int) $this->input('page', 1),
            'perPage' => (int) $this->input('perPage', self::DEFAULT_PER_PAGE),
        ]);
    }
}
