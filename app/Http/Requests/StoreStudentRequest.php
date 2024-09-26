<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => 'required|string|unique:students,username',
            'name' => 'required|string|max:255',
            'gurdian' => 'required|string|max:255',
            'admissiondate' => 'required|date',
            'dob' => 'required|date',
            'gender' => 'required|string|in:male,female,other',
            'religion' => 'required',
            'email' => 'nullable|email|max:255',
            'phone' => 'required',
            'address' => 'nullable|string|max:255',
            'class' => 'required',
            'section' => 'required',
            'group' => 'required|string|in:arts,science,commerce',
            'registration' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }
}
