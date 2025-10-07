<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChapterRequest;
use App\Models\Chapter;
use App\Models\Course;
use Exception;
use Illuminate\Http\Request;

class ChaptersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($course_id)
	{
		$course = Course::find($course_id);
		$chapters = Chapter::where("course_id", $course_id)->orderBy('id', 'ASC')->get();
        // dd($chapters);
		return view("chapters.index", compact("course", "chapters"));
	}

    /**
     * Show the form for creating a new resource.
     */
    public function create($course_id)
	{
		$course = Course::find($course_id);
		return view("chapters.create", compact("course"));
	}
    /**
     * Store a newly created resource in storage.
     */
    public function store(ChapterRequest $request,$course_id)
    {
        try{
            Chapter::create([
                'name' =>[
                    'ar' => $request->name_ar ,
                    'en' => $request->name_en 
                ],
                'order' => $request->order,
                'course_id' => $request->course_id
            ]);
            return redirect()->route('chapters.index', $course_id)->with('success', __('Chapter created successfully'));
        }catch(Exception $e ){
            return back()->with('error', __('Error creating chapter: ') . $e->getMessage());
        }
   
    }

    /**
     * Display the specified resource.
     */
    public function show(Chapters $chapters)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($course_id, $id)
    {
        try {
            $course = Course::findOrFail($course_id);
            $chapter = Chapter::findOrFail($id);
            return view('chapters.edit', compact('course', 'chapter'));
        } catch (ModelNotFoundException $e) {
            return back()->with('error', __('Chapter or course not found'));
        }
    }
    
    public function update(ChapterRequest $request, $course_id, $id)
    {
        try {
            $chapter = Chapter::findOrFail($id);
            $chapter->update([
                'name' => [
                    'ar' => $request->name_ar,
                    'en' => $request->name_en
                ],
                'order' => $request->order,
                'course_id' => $course_id
            ]);
            
            return redirect()->route('chapters.index', $course_id)
                ->with('success', __('Chapter updated successfully'));
        } catch (Exception $e) {
            return back()->with('error', __('Error updating chapter: ') . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $chapter = Chapter::find($id);
            $chapter->delete();
            return redirect()->route('chapters.index')->with('success', __('Chapter deleted successfully'));
        }catch(Exception $e){
            return back()->with('error', __('Error deleting chapter: ') . $e->getMessage());
        }
    }
}
