<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;



class TimeTableRequest extends FormRequest
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
            'day' => 'required', // e.g., Monday, Tuesday, etc.
            'start_time' => 'required', // Validates time in format HH:MM (24-hour)
            'end_time' => 'required', // End time must be after start time
            'class_id' => 'required', // Assuming you have a classes table
            'section_id' => 'required', // Assuming you have a sections table
            'subject_id' => 'required', // Assuming you have a subjects table
            'teacher_id' => 'required', // Assuming you have a teachers table
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
            'day.required' => 'The day is required.',
            'start_time.required' => 'The start time is required.',
            'start_time.date_format' => 'The start time must be in the format HH:MM.',
            'end_time.required' => 'The end time is required.',
            'end_time.date_format' => 'The end time must be in the format HH:MM.',
            'end_time.after' => 'The end time must be after the start time.',
            'class_id.required' => 'The class is required.',
            'class_id.exists' => 'The selected class does not exist.',
            'section_id.required' => 'The section is required.',
            'section_id.exists' => 'The selected section does not exist.',
            'subject_id.required' => 'The subject is required.',
            'subject_id.exists' => 'The selected subject does not exist.',
            'teacher_id.required' => 'The teacher is required.',
            'teacher_id.exists' => 'The selected teacher does not exist.',
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
