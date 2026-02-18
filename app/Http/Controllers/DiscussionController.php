<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Events\DiscussionPosted;

class DiscussionController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string'
        ]);

        $discussion = Discussion::create([
            'course_id' => $id,
            'user_id' => auth()->id(),
            'content' => $request->content
        ]);


        broadcast(new DiscussionPosted($discussion))->toOthers();

        return response()->json($discussion, 201);
    }

    public function index($id)
    {
        $discussions = Discussion::with(['user', 'replies.user'])
            ->where('course_id', $id)
            ->latest()
            ->get();

        return response()->json($discussions);
    }
}
