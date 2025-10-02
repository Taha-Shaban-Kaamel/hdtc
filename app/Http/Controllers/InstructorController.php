<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instructors = Instructor::latest()->paginate(10);
        return view('instructors.index', compact('instructors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('instructors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('profile_photo');
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('instructors', 'public');
            $data['profile_photo_path'] = $path;
        }

        $instructor = Instructor::create($data);

        return redirect()->route('instructors.show', $instructor)
            ->with('success', __('instructors.created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Instructor $instructor)
    {
        return view('instructors.show', compact('instructor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Instructor $instructor)
    {
        return view('instructors.edit', compact('instructor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Instructor $instructor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('instructors')->ignore($instructor->id),
            ],
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'job_title' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'is_active' => 'boolean',
        ]);

        $data = $request->except('profile_photo');
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('profile_photo')) {
            // Delete old profile photo if it exists
            if ($instructor->profile_photo_path) {
                Storage::disk('public')->delete($instructor->profile_photo_path);
            }
            
            $path = $request->file('profile_photo')->store('instructors', 'public');
            $data['profile_photo_path'] = $path;
        }

        $instructor->update($data);

        return redirect()->route('instructors.show', $instructor)
            ->with('success', __('instructors.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instructor $instructor)
    {
        // Delete profile photo if it exists
        if ($instructor->profile_photo_path) {
            Storage::disk('public')->delete($instructor->profile_photo_path);
        }

        $instructor->delete();

        return redirect()->route('instructors.index')
            ->with('success', __('instructors.deleted_successfully'));
    }
}
