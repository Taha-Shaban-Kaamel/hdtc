<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstructorRequest extends FormRequest
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
            'first_name_ar' => 'required|string|max:255',
            'first_name_en' => 'required|string|max:255',
            'second_name_ar' => 'required|string|max:255',
            'second_name_en' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'specialization_ar' => 'required|string|max:255',
            'specialization_en' => 'required|string|max:255',
            'experience' => 'required|string|max:255',
            'education_ar' => 'required|string|max:255',
            'education_en' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'email' => 'required|string|unique:users,email|max:255',
            'bio_ar' => 'nullable|string',
            'bio_en' => 'nullable|string',
            'phone' => 'nullable|phone:EG',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'company' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'password' => 'required|string|min:8' ,
            'is_active' => 'boolean',
        ];
    }

    public function messages() {
        return [
            'first_name_ar.required' => __('validation.required'),
            'first_name_en.required' => __('validation.required'),
            'second_name_ar.required' => __('validation.required'),
            'second_name_en.required' => __('validation.required'),
            'gender.required' => __('validation.required'),
            'birth_date.required' => __('validation.required'),
            'specialization_ar.required' => __('validation.required'),
            'specialization_en.required' => __('validation.required'),
            'experience.required' => __('validation.required'),
            'education_ar.required' => __('validation.required'),
            'education_en.required' => __('validation.required'),
            'company.required' => __('validation.required'),
            'twitter_url.required' => __('validation.required'),
            'linkedin_url.required' => __('validation.required'),
            'facebook_url.required' => __('validation.required'),
            'youtube_url.required' => __('validation.required'),
            'email.required' => __('validation.required'),
            'bio_ar.required' => __('validation.required'),
            'bio_en.required' => __('validation.required'),
            'phone.required' => __('validation.required'),
            'avatar.required' => __('validation.required'),
            'company.required' => __('validation.required'),
            'website.required' => __('validation.required'),
            'twitter_url.required' => __('validation.required'),
            'linkedin_url.required' => __('validation.required'),
            'facebook_url.required' => __('validation.required'),
            'youtube_url.required' => __('validation.required'),
            'password.required' => __('validation.required'),
            'is_active.required' => __('validation.required'),
        ];
    }
}
