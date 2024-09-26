<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Set to true to allow all users to access this request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Determine if it's an update request
        $employeeId = $this->route('id'); // Assuming 'id' is the route parameter for employee ID

        return [
            'name' => 'required|string|max:30',
            'gender' => 'required',
            'date_of_birth' => 'required|date',
            'designation_id' => 'required|integer',

            // For email, exclude the current employee ID if it's an update request
            'email' => 'required|email|unique:employees,email,' . $employeeId,

            'phone' => 'required|string',
            'address' => 'required|string|max:100',

            // Password is required only for creation, but can be nullable for updates
            'password' => $this->isMethod('post') ? 'required|string|min:8' : 'nullable|string|min:8',

            'salary' => 'required|numeric',
            'joining_date' => 'required|date',
            'image' => $this->isMethod('post') ? 'required|image' : 'nullable|image',
            'religion' => 'required|string',
        ];
    }

    /**
     * Get custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'The employee name is required.',
            'email.unique' => 'This email has already been taken by another employee.',
            'password.min' => 'The password must be at least 8 characters long.',
            // Add more custom messages if needed
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  Validator  $validator
     * @return void
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors occurred.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
