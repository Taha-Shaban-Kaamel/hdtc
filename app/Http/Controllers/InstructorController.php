<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstructorRequest;
use App\Models\Instructor;
use App\Http\Resources\InstructorResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Models\User;


class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view',Instructor::class);
        $instructors = Instructor::latest()->paginate(10);
        return view('instructors.index', compact('instructors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create',Instructor::class);
        return view('instructors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InstructorRequest $request)
    {
        $this->authorize('create',Instructor::class);
        $validated = $request->validated();
        $request = request() ;

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->move(storage_path('app/public/instructors'), Str::random(10) . '.' . $request->file('avatar')->getClientOriginalExtension());
            $validated['avatar'] = 'storage/instructors/' . $path->getFilename();
        }

        $user = User::create([
            'first_name' => ['ar' => $request->first_name_ar , 'en' => $request->first_name_en],
            'second_name' => ['ar' => $request->second_name_ar , 'en' => $request->second_name_en],
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'email' => $request->email,
            'phone' => $request->phone,
            'bio' => ['ar' => $request->bio_ar , 'en' => $request->bio_en],
            'password' => bcrypt($request->password),
            'avatar' => $validated['avatar'] ?? null,
        ]);

        $user->assignRole('instructor');

        $instructor = Instructor::create([
            'user_id' => $user->id,
            'specialization' => ['ar' => $request->specialization_ar , 'en' => $request->specialization_en],
            'education' => ['ar' => $request->education_ar , 'en' => $request->education_en],
            'bio' => ['ar' => $request->bio_ar , 'en' => $request->bio_en],
            'experience' => $request->experience,
            'company' => $request->company,
            'twitter_url' => $request->twitter_url,
            'linkedin_url' => $request->linkedin_url,
            'facebook_url' => $request->facebook_url,
            'youtube_url' => $request->youtube_url,
            'is_active' => $request->has('is_active'),
        ]);





        return redirect()->route('web.instructors.show', $instructor)
            ->with('success', __('instructors.created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Instructor $instructor)
    {
        $this->authorize('view',Instructor::class);
        $instructor = $instructor->load('user');
        return view('instructors.show', compact('instructor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Instructor $instructor)
    {
        $this->authorize('edit',Instructor::class);
        $instructor = $instructor->load('user');
        return view('instructors.edit', compact('instructor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $this->authorize('edit',Instructor::class);
        $instructor = Instructor::findOrFail($id);
        $validated = $request->validate([
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
            'email' => 'required|string|unique:users,email,'.$instructor->user->id.',id|max:255',
            'bio_ar' => 'nullable|string',
            'bio_en' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'job_title' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'facebook_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
        ]);


        if ($request->hasFile('avatar')) { 
                       
            $fileName = $request->file('avatar')->getClientOriginalName();
            $path = $request->file('avatar')->move(storage_path('app/public/instructors'), Str::random(10) . '.' .$fileName);
            $validated['avatar'] = 'storage/instructors/' . $path->getFilename();
        }

        $userData = [
            'first_name' => [
                'ar' => $validated['first_name_ar'],
                'en' => $validated['first_name_en']
            ],
            'second_name' => [
                'ar' => $validated['second_name_ar'],
                'en' => $validated['second_name_en']
            ],
            'gender' => $validated['gender'],
            'birth_date' => $validated['birth_date'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'bio' => [
                'ar' => $validated['bio_ar'],
                'en' => $validated['bio_en']
            ],
            'avatar' => $validated['avatar'] ?? null,
            'password' => bcrypt('password'),
        ];

        $instructorData = [
            'specialization' => [
                'ar' => $validated['specialization_ar'],
                'en' => $validated['specialization_en']
            ],
            'education' => [
                'ar' => $validated['education_ar'],
                'en' => $validated['education_en']
            ],
            'experience' => $validated['experience'],
            'company' => $validated['company'],
            'twitter_url' => $validated['twitter_url'],
            'linkedin_url' => $validated['linkedin_url'],
            'facebook_url' => $validated['facebook_url'],
            'youtube_url' => $validated['youtube_url'],
        ];



        $data = $validated; 


        $instructor->user->update($userData);
        $instructor->update($instructorData);

        return redirect()->route('web.instructors.show', $instructor)
            ->with('success', __('instructors.updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instructor $instructor)
    {
        $this->authorize('delete',Instructor::class);

        if ($instructor->profile_photo_path) {
            Storage::disk('public')->delete($instructor->profile_photo_path);
        }

        $instructor->delete();

        return redirect()->route('web.instructors.index')
            ->with('success', __('instructors.deleted_successfully'));
    }
}
