<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Traits\HttpResponseTrait;
use Illuminate\Contracts\Validation\Validator;

class TaskRequest extends FormRequest
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
            'title' => 'required|max:255',
            'planned_date' => 'nullable|date|after_or_equal:today',
            'status' => 'required|in:todo,completed,on-going',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required!',
            'title.max' => 'Title should not be more that 255 characters!',

            'planned_date.date' => 'Planned date must be a valid date!',
            'planned_date.after_or_equal' => 'Planned date must be a later than today!',

            'status.required' => 'Status is required!',
            'status.min' => 'Status is invalid!',
        ];
    }

    // Modifies the format of the returned error messages
    protected function failedValidation(Validator $validator)
    {
        throw($this->failedFormValidationResponse($validator)); 
    }

    
}
