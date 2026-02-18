<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function index()
    {
        return Course::with('lecturer')->get();
    }


    public function store(Request $request)
    {
        if(auth()->user()->role !== 'dosen') {
            return response()->json(['message'=>'Forbidden'],403);
        }

        $request->validate([
            'name' => 'required',
            'description' => 'nullable'
        ]);

        $course = Course::create([
            'name' => $request->name,
            'description' => $request->description,
            'lecturer_id' => auth()->id()
        ]);

        return response()->json($course,201);
    }
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        if(auth()->user()->role !== 'dosen') {
            return response()->json(['message'=>'Forbidden'],403);
        }

        $course->update($request->only('name','description'));

        return response()->json($course);
    }


    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        if(auth()->user()->role !== 'dosen') {
            return response()->json(['message'=>'Forbidden'],403);
        }

        $course->delete();

        return response()->json(['message'=>'Deleted']);
    }

    
    public function enroll($id)
    {
        $course = Course::findOrFail($id);

        $course->students()->attach(auth()->id());

        return response()->json(['message'=>'Berhasil enroll']);
    }
}
