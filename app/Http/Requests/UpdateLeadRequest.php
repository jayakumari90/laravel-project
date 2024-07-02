<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Contracts\Validation\Validator;

class UpdateLeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function authorize(): bool
    {
        return true;
    }
    
    public function rules()
    {
        if ($this->skipValidation) {
            return [];
        }

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'string|max:20',
            'address' => 'nullable|string|max:255',
        ];
    }

    public function withValidator($validator)
    {
        if ($this->skipValidation) {
            $validator->after(function ($validator) {
                $validator->errors()->clear();
            });
        }
    }

}
