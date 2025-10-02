<?php

namespace App\Http\Controllers;

use App\Models\CourseCategorie;
use Illuminate\Http\Request;

class CourseCategorieController extends Controller
{
  
    public function index()
    {
        $categories = CourseCategorie::all();
        return view('courses.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = CourseCategorie::all();
        return view('courses.categories.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'parent_id' => 'nullable|exists:course_categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ],[
            'name_ar.required' => 'The name in arabic is required.',
            'name_en.required' => 'The name in english is required.',
            'description_ar.required' => 'The description in arabic is required.',
            'description_en.required' => 'The description in english is required.',
            'parent_id.exists' => 'The selected parent category does not exist.',
            'image.required' => 'The image is required.',
            'image.image' => 'must be an image',
            'image.mimes' => 'The image must be a valid image format (jpeg, png, jpg, gif).',
            'image.max' => 'The image size must not exceed 2MB.',
        ]);
    
        if ($request->hasFile('image')) {
            $fileName = $request->file('image')->getClientOriginalName();
            $fileName = time().$fileName;
            $request->file('image')->move(storage_path('app/public/categories'), $fileName);
            $validated['image'] = 'storage/categories/' . $fileName; 
        }
        $categoryData = [
            'name' => [
                'ar' => $validated['name_ar'],
                'en' => $validated['name_en'],
            ],
            'description' => [
                'ar' => $validated['description_ar'],
                'en' => $validated['description_en'],
            ],
            'parent_id' => $validated['parent_id'] ?? null,
        ];
        
        if (isset($validated['image'])) {
            $categoryData['image'] = $validated['image'];
        }
        CourseCategorie::create($categoryData);
    
        return redirect()->route('courses.categories.index')
                        ->with('success', 'Course category created successfully.');
    }
    public function show($id)
    {
        $courseCategorie = CourseCategorie::findOrFail($id);
        return view('courses.categories.show', compact('courseCategorie'));
    }

    public function edit($id)
    {
        $courseCategorie = CourseCategorie::findOrFail($id);
        return view('courses.categories.edit', compact('courseCategorie'));
    }

    public function update(Request $request, $id)
    {
        $courseCategorie = CourseCategorie::findOrFail($id);
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ],[
            'name_ar.required' => 'The name in arabic is required.',
            'name_en.required' => 'The name in english is required.',
            'description_ar.required' => 'The description in arabic is required.',
            'description_en.required' => 'The description in english is required.',
            'image.image' => 'must be an image',
            'image.mimes' => 'The image must be a valid image format (jpeg, png, jpg, gif).',
            'image.max' => 'The image size must not exceed 2MB.',
        ]);
    
        if ($request->hasFile('image')) {
            if ($courseCategorie->image && file_exists(public_path($courseCategorie->image))) {
                unlink(public_path($courseCategorie->image));
            }
            
            $fileName = $request->file('image')->getClientOriginalName();
            $fileName = time().$fileName;
            $request->file('image')->move(storage_path('app/public/categories'), $fileName);
            $validated['image'] = 'storage/categories/' . $fileName;
        }
        
        $updateData = [
            'name' => [
                'ar' => $validated['name_ar'],
                'en' => $validated['name_en'],
            ],
            'description' => [
                'ar' => $validated['description_ar'],
                'en' => $validated['description_en'],
            ],
        ];
        
        if (isset($validated['image'])) {
            $updateData['image'] = $validated['image'];
        }
        
        $courseCategorie->update($updateData);
    
        return redirect()->route('courses.categories.index')
                        ->with('success', __('courses.updated_successfully'));
    }

    public function destroy($id)
    {
        $courseCategorie = CourseCategorie::findOrFail($id);
        $courseCategorie->delete();
        return redirect()->route('courses.categories.index')
                        ->with('success', __('courses.deleted_successfully'));
    }
}
