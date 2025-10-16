<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnrollmentRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id'],
            'course_id' => ['required', 'exists:courses,id', 'unique:enrollments,course_id,NULL,id,user_id,' . $this->user_id],
            'status' => ['sometimes', 'string', 'in:active,completed,dropped'],
            'progress' => ['sometimes', 'numeric', 'min:0', 'max:100'],
            'grade' => ['sometimes', 'numeric', 'min:0', 'max:100'],
            'completion_date' => ['sometimes', 'nullable', 'date'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'course_id.unique' => 'This user is already enrolled in the specified course.',
        ];
    }
}
