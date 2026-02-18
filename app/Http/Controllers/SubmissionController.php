<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function store(Request $request, $id)
    {
        if (auth()->user()->role !== 'mahasiswa') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $request->validate([
            'file' => 'required|file|max:2048'
        ]);

        $filePath = $request->file('file')->store('submissions');

        $submission = Submission::create([
            'assignment_id' => $id,
            'student_id' => auth()->id(),
            'file_path' => $filePath,
        ]);

        return response()->json($submission, 201);
    }
    public function grade(Request $request, $id)
    {
        if (auth()->user()->role !== 'dosen') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $request->validate([
            'score' => 'required|integer|min:0|max:100'
        ]);

        $submission = Submission::findOrFail($id);
        $submission->update([
            'score' => $request->score
        ]);

        return response()->json(['message' => 'Score updated']);
    }
}
