<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class authController extends Controller
{

    public function register(Request $request){
        $validated = $request->validate([
            'first_name_ar' => 'required|string|max:255',
            'first_name_en' => 'required|string|max:255',
            'second_name_ar' => 'required|string|max:255',
            'second_name_en' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'birth_date' => 'nullable|date|before:today',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
        ], [
            'first_name_ar.required' => 'The first name field is required in all languages.',
            'first_name_en.required' => 'The first name field is required in all languages.',
            'second_name_ar.required' => 'The last name field is required in all languages.',
            'second_name_en.required' => 'The last name field is required in all languages.',
            'gender.required' => 'The gender field is required in all languages.',
            'gender.in' => 'Please select a valid gender in English (male, female, other).',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already in use.',
            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'avatar.image' => 'The file must be an image.',
            'avatar.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
            'avatar.max' => 'The image may not be greater than 2MB.',
            'birth_date.date' => 'Please enter a valid date.',
            'birth_date.before' => 'The birth date must be in the past.',
            'phone.max' => 'The phone number may not be greater than 20 characters.',
            'bio.max' => 'The bio may not be greater than 500 characters.'
        ]);

        $user = User::create([
            'first_name_ar' => $validated['first_name_ar'],
            'first_name_en' => $validated['first_name_en'],
            'second_name_ar' => $validated['second_name_ar'],
            'second_name_en' => $validated['second_name_en'],
            'gender' => $validated['gender'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'avatar' => $validated['avatar'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'bio' => $validated['bio'] ?? null,
        ]);

        $user->assignRole('student');

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'data' => [
                'user' => new UserResource($user),
                'token' => $token
            ]
        ]);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if (!auth()->attempt($validated)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ]);
        }

        $user = auth()->user();
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'data' => [
                'user' => new UserResource($user),
                'token' => $token
            ]
        ]);
    }
    
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out'
        ]);
    }

    public function getUserProfile(Request $request)
    {
        $user = $request->user()->with('userType')->find($request->user()->id);
        return response()->json([
            'success' => true,
            'data' => new UserResource($user)
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'first_name_ar' => 'required|string|max:255',
            'first_name_en' => 'required|string|max:255',
            'second_name_ar' => 'required|string|max:255',
            'second_name_en' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'birth_date' => 'nullable|date|before:today',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
        ], [
            'first_name_ar.required' => 'The first name field is required in all languages.',
            'first_name_en.required' => 'The first name field is required in all languages.',
            'second_name_ar.required' => 'The last name field is required in all languages.',
            'second_name_en.required' => 'The last name field is required in all languages.',
            'gender.required' => 'The gender field is required in all languages.',
            'gender.in' => 'Please select a valid gender in English (male, female, other).',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already in use.',
            'avatar.image' => 'The file must be an image.',
            'avatar.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
            'avatar.max' => 'The image may not be greater than 2MB.',
            'birth_date.date' => 'Please enter a valid date.',
            'birth_date.before' => 'The birth date must be in the past.',
            'phone.max' => 'The phone number may not be greater than 20 characters.',
            'bio.max' => 'The bio may not be greater than 500 characters.'
        ]);

        $updateData = [];

        $user->setTranslation('first_name', 'ar', $validated['first_name_ar']);
        $user->setTranslation('first_name', 'en', $validated['first_name_en']);
        $user->setTranslation('second_name', 'ar', $validated['second_name_ar']);
        $user->setTranslation('second_name', 'en', $validated['second_name_en']);

        $fields = ['gender', 'email', 'birth_date', 'phone', 'bio', 'avatar'];
        foreach ($fields as $field) {
            if ($request->filled($field)) {
                $updateData[$field] = $validated[$field];
            }
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar && file_exists(storage_path('app/public/' . $user->avatar))) {
                unlink(storage_path('app/public/' . $user->avatar)) ;
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        $user->update($updateData);

        return response()->json([
            'success' => true,
            'data' => new UserResource($user->load('userType'))
        ]);
    }
}
