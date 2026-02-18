<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function store(Request $request, $id)
{
    $request->validate([
        'content' => 'required|string'
    ]);

    $reply = Reply::create([
        'discussion_id' => $id,
        'user_id' => auth()->id(),
        'content' => $request->content
    ]);

    return response()->json($reply, 201);
}

}
