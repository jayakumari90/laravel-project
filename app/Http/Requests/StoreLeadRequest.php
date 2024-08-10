<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;

class StoreLeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return true;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/^[0-9]{10}$/', // Ensures phone is exactly 10 digits
            'address' => 'nullable|string|max:255',
            'lead' => 'required|integer',
            'source' => 'required|string',
            'staff' => 'integer',
            'tag' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'country' => 'nullable|integer',
            'state' => 'nullable|integer',
            'city' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'lead_value' => 'nullable|numeric',
            'default_language' => 'integer',
            'company' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ];
    }
    
    public function failedValidation(Validator $validator)

    {

        throw new HttpResponseException(response()->json([

            'status'   => false,

            'message'   => 'Validation errors',

            'data'      => $validator->errors()

        ]));

    }

}
