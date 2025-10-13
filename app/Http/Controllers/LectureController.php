<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use App\Models\Course;
use App\Models\Chapter;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    public function index(Course $course, Chapter $chapter)
    {
        $this->authorize('viewAny', Course::class);
        $lectures = $chapter->lectures()->orderBy('order')->get();
        return view('lectures.index', compact('course', 'chapter', 'lectures'));
    }

    public function create(Course $course, Chapter $chapter)
    {
        $this->authorize('create', Course::class);
        return view('lectures.create', compact('course', 'chapter'));
    }

    public function store(Request $request, Course $course, Chapter $chapter)
    {
        $this->authorize('create', Course::class);

        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'video_url' => 'required|url',
            'type' => 'nullable|string',
            'order' => 'nullable|integer',
            'exam' => 'nullable|string',
        ]);

        $chapter->lectures()->create([
            'course_id' => $course->id ,
            'chapter_id' => $chapter->id,
            'title' => [
                'ar' => $validated['title_ar'],
                'en' => $validated['title_en']
            ],
            'video_url' => $validated['video_url'],
            'type' => $validated['type'] ?? 'lecture',
            'order' => $validated['order'] ?? 0,
            'exam' => $validated['exam'] ?? null,
        ]);

        return redirect()->route('lectures.index', [$course->id, $chapter->id])
            ->with('success', __('Lecture created successfully.'));
    }

    public function edit(Course $course, Chapter $chapter, Lecture $lecture)
    {
        $this->authorize('update', Course::class);
        return view('lectures.edit', compact('course', 'chapter', 'lecture'));
    }

    public function update(Request $request, Course $course, Chapter $chapter, Lecture $lecture)
    {
        $this->authorize('update', Course::class);
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'video_url' => 'required|url',
            'type' => 'nullable|string',
            'order' => 'nullable|integer',
            'exam' => 'nullable|string',
        ]);

        $lecture->update([
            'title' => [
                'ar' => $validated['title_ar'],
                'en' => $validated['title_en']
            ],
            'video_url' => $validated['video_url'],
            'type' => $validated['type'] ?? 'lecture',
            'order' => $validated['order'] ?? 0,
            'exam' => $validated['exam'] ?? null,
        ]);

        return redirect()->route('lectures.index', [$course->id, $chapter->id])
            ->with('success', __('Lecture updated successfully.'));
    }

    public function destroy(Course $course, Chapter $chapter, Lecture $lecture)
    {
        $this->authorize('delete', Course::class);
        $lecture->delete();
        return back()->with('success', __('Lecture deleted successfully.'));
    }
}