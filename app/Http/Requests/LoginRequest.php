<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Traits\HttpResponseTrait;
use Illuminate\Contracts\Validation\Validator;

class LoginRequest extends FormRequest
{
    // This Trait handles the formatting of the JSON response on the app
    use HttpResponseTrait;

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
            'email' => 'required|string|email',
            'password' => 'required|string|min:4',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email is required!',
            'email.email' => 'Email is invalid!',

            'password.required' => 'Password is required!',
            'password.min' => 'Password must have not less than 4 characters in length!',
        ];
    }

    // Modifies the format of the returned error messages
    protected function failedValidation(Validator $validator)
    {
        throw($this->failedFormValidationResponse($validator)); 
    }

    
}
