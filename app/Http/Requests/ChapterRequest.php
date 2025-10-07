<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChapterRequest extends FormRequest
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
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'order' => 'required|numeric',
            'course_id' => 'required|exists:courses,id',
        ];
    }

    public function messages()
    {
        return [
            "name_ar.unique" => trans('validation.required'),
            'name_en.required' => trans('validation.required'),
            'order.required' => trans('validation.required'),
            'course_id.required' => trans('validation.required'),
            'course_id.exists' => trans('validation.exists'),
            'order.numeric' => trans('validation.numeric'),

        ];
    }
}
