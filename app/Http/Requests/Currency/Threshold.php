<?php

namespace App\Http\Requests\Currency;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Auth;

class Threshold extends FormRequest
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
        return [
                'target_currency' => ['required', 'string', 'min:3',
                'unique:currency_thresholds,target_currency,NULL,id,user_id,' . Auth::id(),
                'max:4', 'regex:/^[a-zA-Z\-\.]+$/'
                ],
                'currency_name' => ['nullable', 'string', 'max:12', 'regex:/^[a-zA-Z\-]+$/'],
                'threshold_number' => ['required', 'numeric'],
                'condition' => ['required', 'in:greater_than,less_than,equal_to'],
        ];
    }

    public function messages()
    {
        return [
                'target_currency.unique' => 'The target currency has already been taken by you',
        ];
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
}
