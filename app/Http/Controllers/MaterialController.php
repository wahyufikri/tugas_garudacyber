<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function store(Request $request, $id)
    {
        
        if (auth()->user()->role !== 'dosen') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:2048'
        ]);

        $course = Course::findOrFail($id);

        $filePath = $request->file('file')->store('materials');

        $material = Material::create([
            'course_id' => $course->id,
            'title' => $request->title,
            'file_path' => $filePath
        ]);

        return response()->json([
            'message' => 'Material uploaded successfully',
            'data' => $material
        ], 201);
    }
    public function download($id)
    {
        $material = Material::findOrFail($id);

        if (!Storage::exists($material->file_path)) {
            return response()->json(['message' => 'File not found'], 404);
        }

        return Storage::download($material->file_path);
    }
}
