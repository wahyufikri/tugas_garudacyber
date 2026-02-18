<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function courseStats()
    {
     
        if(auth()->user()->role !== 'dosen'){
            return response()->json(['message'=>'Forbidden'],403);
        }

        $courses = Course::withCount('students')->get();

        return response()->json([
            'data' => $courses
        ]);
    }

    public function submissionStats()
    {
        if(auth()->user()->role !== 'dosen'){
            return response()->json(['message'=>'Forbidden'],403);
        }

        $graded = Submission::whereNotNull('score')->count();
        $ungraded = Submission::whereNull('score')->count();

        return response()->json([
            'graded' => $graded,
            'ungraded' => $ungraded
        ]);
    }

    public function studentStats($id)
    {
        if(auth()->user()->role !== 'dosen'){
            return response()->json(['message'=>'Forbidden'],403);
        }

        $student = User::findOrFail($id);

        $stats = Submission::where('student_id', $id)
            ->selectRaw('COUNT(*) as total, AVG(score) as average')
            ->first();

        return response()->json([
            'student_name' => $student->name,
            'total_submissions' => (int) ($stats->total ?? 0),
            'average_score' => round($stats->average ?? 0, 2)
        ]);
    }
}
