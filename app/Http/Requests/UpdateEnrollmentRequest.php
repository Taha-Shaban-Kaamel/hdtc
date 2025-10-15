<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEnrollmentRequest extends FormRequest
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
            'status' => ['sometimes', 'string', 'in:active,completed,dropped'],
            'progress' => ['sometimes', 'numeric', 'min:0', 'max:100'],
            'grade' => ['sometimes', 'numeric', 'min:0', 'max:100'],
            'completion_date' => ['sometimes', 'nullable', 'date'],
        ];
    }
}
