<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategorieResrource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\InstructorResource;
use App\Models\Course;
use App\Models\CourseCategorie;
use App\Models\Instructor;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::paginate(10)->load('categories', 'instructors','tags');
        $courses = CourseResource::collection($courses)->toArray(request());
        // dd($courses);
        return view('courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = CourseCategorie::all();
        $categories = CategorieResrource::collection($categories)->toArray(request());
        $instructors = InstructorResource::collection(Instructor::all())->toArray(request());

        return view('courses.create', compact('categories', 'instructors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'objectives_ar' => 'nullable|string',
            'objectives_en' => 'nullable|string',
            'difficulty_degree' => 'required|in:beginner,intermediate,advanced',
            'instructors' => 'required|array',
            'instructors.*' => 'exists:instructors,id',
            'categories' => 'required|array',
            'categories.*' => 'exists:course_categories,id',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'required|url',
            'price' => 'required|numeric',
            'duration' => 'required|numeric',
        ]);

        try {
            $thumbnailPath = null;
            $coverPath = null;
            if ($request->hasFile('thumbnail')) {
                $imageName = Str::random(10) . $request->file('thumbnail')->getClientOriginalName();
                $thumbnailPath = $request->file('thumbnail')->move(storage_path('app/public/courses/thumbnails'), $imageName);
                $thumbnailPath = 'storage/courses/thumbnails/' . $imageName;
            }
            if ($request->hasFile('cover')) {
                $imageName = Str::random(10) . $request->file('cover')->getClientOriginalName();
                $coverPath = $request->file('cover')->move(storage_path('app/public/courses/covers'), $imageName);
                $coverPath = 'storage/courses/covers/' . $imageName;
            }

            $course = Course::create([
                'title' => [
                    'ar' => $validated['title_ar'],
                    'en' => $validated['title_en'],
                ],
                'name' => [
                    'ar' => $validated['name_ar'],
                    'en' => $validated['name_en'],
                ],
                'description' => [
                    'ar' => $validated['description_ar'],
                    'en' => $validated['description_en'],
                ],
                'objectives' => [
                    'ar' => $validated['objectives_ar'] ?? '',
                    'en' => $validated['objectives_en'] ?? '',
                ],
                'price' => $validated['price'],
                'duration' => $validated['duration'],
                'difficulty_degree' => $validated['difficulty_degree'],
                'thumbnail' => $thumbnailPath,
                'cover' => $coverPath,
                'video' => $validated['video_url'],
                'status' => $validated['status'] ?? 'active',
            ]);

            if ($request->has('tags')) {
                $tagIds = collect(json_decode($request->tags[0], true))
                    ->map(function ($tagData) {
                        return Tag::firstOrCreate(
                            ['name' => $tagData['value']],
                            ['slug' => \Illuminate\Support\Str::slug($tagData['value'])]
                        )->id;
                    })
                    ->toArray();

                $course->tags()->sync($tagIds);
            }
            $course->categories()->attach($validated['categories']);
            $course->instructors()->attach($validated['instructors']);

            return redirect()
                ->route('courses.index')
                ->with('success', __('courses.created_successfully'));
        } catch (\Exception $e) {
            // Clean up uploaded files if something went wrong
            if (isset($thumbnailPath) && Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }
            if (isset($coverPath) && Storage::disk('public')->exists($coverPath)) {
                Storage::disk('public')->delete($coverPath);
            }

            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create course. Please try again. ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course = Course::findOrFail($course->id)->load('categories', 'instructors');
        $categories = CourseCategorie::all();
        $categories = CategorieResrource::collection($categories)->toArray(request());
        $instructors = InstructorResource::collection(Instructor::all())->toArray(request());
        return view('courses.show', compact('course', 'categories', 'instructors'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $course = Course::with(['categories', 'instructors', 'tags'])->findOrFail($id);
        // $course = new CourseResource($course);

        $categories = CourseCategorie::all();
        $categories = CategorieResrource::collection($categories)->toArray(request());
        $instructors = InstructorResource::collection(Instructor::all())->toArray(request());
        return view('courses.edit', compact('course', 'categories', 'instructors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title_ar' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'objectives_ar' => 'nullable|string',
            'objectives_en' => 'nullable|string',
            'difficulty_degree' => 'nullable|in:beginner,intermediate,advanced',
            'instructors' => 'nullable|array',
            'instructors.*' => 'exists:instructors,id',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:course_categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video_url' => 'nullable|url',
            'price' => 'nullable|numeric',
            'duration' => 'nullable|numeric',
        ]);
        $courseData = [];

        if (isset($validated['cover'])) {
            if ($course->cover) {
                $coverPath = str_replace('storage/', '', $course->cover);
                if (file_exists(storage_path('app/public/' . $coverPath))) {
                    unlink(storage_path('app/public/' . $coverPath));
                }
            }
            $imageName = Str::random(10) . $request->file('cover')->getClientOriginalName();
            $coverPath = $request->file('cover')->move(storage_path('app/public/courses/covers'), $imageName);
            $courseData['cover'] = 'storage/courses/covers/' . $imageName;
        }

        if (isset($validated['thumbnail'])) {
            if ($course->thumbnail) {
                $thumbnailPath = str_replace('storage/', '', $course->thumbnail);
                if (file_exists(storage_path('app/public/' . $thumbnailPath))) {
                    unlink(storage_path('app/public/' . $thumbnailPath));
                }
            }
            $imageName = Str::random(10) . $request->file('thumbnail')->getClientOriginalName();
            $thumbnailPath = $request->file('thumbnail')->move(storage_path('app/public/courses/thumbnails'), $imageName);
            $courseData['thumbnail'] = 'storage/courses/thumbnails/' . $imageName;
        }

        $courseData['title'] = [
            'ar' => $validated['title_ar'],
            'en' => $validated['title_en']
        ];

        $courseData['name'] = [
            'ar' => $validated['name_ar'],
            'en' => $validated['name_en']
        ];

        $courseData['description'] = [
            'ar' => $validated['description_ar'],
            'en' => $validated['description_en']
        ];

        $courseData['objectives'] = [
            'ar' => $validated['objectives_ar'],
            'en' => $validated['objectives_en']
        ];

        $courseData['price'] = $validated['price'];
        $courseData['duration'] = $validated['duration'];
        $courseData['video'] = $validated['video_url'];

        $courseData['difficulty_degree'] = $validated['difficulty_degree'];

        // dd($courseData);

        try {
            \DB::beginTransaction();

            $course->update($courseData);

            if (isset($validated['categories'])) {
                $course->categories()->sync($validated['categories']);
            };

            if (isset($validated['instructors'])) {
                $course->instructors()->sync($validated['instructors']);
            };

            \DB::commit();

            return redirect()
                ->route('courses.index')
                ->with('success', __('courses.updated_successfully'));
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update course. Please try again. ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        try {
            $course->delete();
            return redirect()
                ->route('courses.index')
                ->with('success', __('courses.deleted_successfully'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to delete course. Please try again. ' . $e->getMessage()]);
        }
    }
}
