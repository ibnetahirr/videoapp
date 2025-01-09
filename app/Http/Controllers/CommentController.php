<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;


class CommentController extends Controller
{
    public function store(Request $request) {
        $request->validate(['comment' => 'required|string']);

        Comment::create([
            'user_id' => auth()->id(),
            'video_id' => $request->video_id,
            'comment' => $request->comment,
        ]);

        return redirect()->back();
    }

}
