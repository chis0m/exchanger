<?php

namespace App\Http\Requests\User;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Configuration;

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
        if ($numberOfCurrency == Configuration::RANGE[2]) {
            $baseCurrencyValidation = ['nullable', 'string', 'max:4', 'min:3'];
        } else {
            $baseCurrencyValidation = ['nullable', 'string', 'max:4', 'min:3', 'in:EUR,eur'];
        }
        return [
            'first_name' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z\-\.]+$/'],
            'last_name' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z\-\.]+$/'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email,' . $this->user()->id],
            'phone' => ['nullable', 'string', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10'],
            'base_currency' => $baseCurrencyValidation,
            'country' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages()
    {
        $numberOfCurrency = $this->getConfiguration();
        if ($numberOfCurrency != Configuration::RANGE[2]) {
            return [
                'base_currency.in' => 'Only EUR is allowed',
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

    public function getConfiguration()
    {
        return Configuration::whereSlug('number_of_currencies')->first()['value'];
    }
}
