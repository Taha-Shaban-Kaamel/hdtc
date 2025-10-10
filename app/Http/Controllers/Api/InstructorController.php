<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\InstructorResource;
use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function index()
    {
        try {
            $instructors = InstructorResource::collection(Instructor::all()) ;
            return response()->json([
                'status' => true,
                'message' => 'Instructors found',
                'data' => $instructors,
                'count' => $instructors->count()
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Instructors not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function show(string $id)
    {
        try {
            $instructor = new InstructorResource(Instructor::find($id)) ;
            return response()->json([
                'status' => true,
                'message' => 'Instructor found',
                'data' => $instructor,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Instructor not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

}
