<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Course;
use App\Notifications\NewAssignmentNotification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AssignmentController extends Controller
{
    public function store(Request $request, $id)
    {
        if (auth()->user()->role !== 'dosen') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'deadline' => 'required|date_format:Y-m-d H:i:s'
        ]);

        $course = Course::findOrFail($id);

        $assignment = Assignment::create([
            'course_id' => $course->id,
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => Carbon::parse($request->deadline)
        ]);

        $students = $course->students;

        foreach ($students as $student) {
            $student->notify(new NewAssignmentNotification($assignment));
        }

        return response()->json([
            'message' => 'Assignment created & notification sent',
            'data' => $assignment
        ], 201);
    }
}
