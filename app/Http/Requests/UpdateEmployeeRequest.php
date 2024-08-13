<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
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
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'date_of_birth' => 'required',
            'gender' => 'required|string',
            'religion' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric|',
            'address' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'joining_date' => 'required|date|before_or_equal:today',
            'status' => 'nullable|string|in:active,inactive,suspended',
        ];
    }
}
