<?php

namespace App\Http\Requests\User;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Configuration;
use App\Models\Currency;

class Detail extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $numberOfCurrency = $this->getConfiguration();
        $allowedCurrency = $this->getAllowedCurrency('EUR');
        if ($numberOfCurrency == Configuration::RANGE[2]) {
            $baseCurrencyValidation = ['nullable', 'exists:currencies,id'];
        } else {
            $baseCurrencyValidation = ['nullable', 'exists:currencies,id', 'in:' . $allowedCurrency->id];
        }
        return [
            'first_name' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z\-\.]+$/'],
            'last_name' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z\-\.]+$/'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email,' . $this->user()->id],
            'phone' => ['nullable', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10'],
            'base_currency_id' => $baseCurrencyValidation,
            'country' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        $numberOfCurrency = $this->getConfiguration();
         $allowedCurrency = $this->getAllowedCurrency('EUR');
        if ($numberOfCurrency != Configuration::RANGE[2]) {
            return [
                'base_currency_id.in' => 'Only ' . $allowedCurrency->symbol . ' is allowed',
            ];
        } else {
            return [];
        }
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
              'success' => false,
              'message' => 'The given data was invalid.',
              'data' => $validator->errors()->toArray()
            ], 422)
        );
    }

    public function getAllowedCurrency($symbol)
    {
        return Currency::whereSymbol($symbol)->first();
    }

    public function getConfiguration()
    {
        return Configuration::config('number_of_currencies');
    }
}
