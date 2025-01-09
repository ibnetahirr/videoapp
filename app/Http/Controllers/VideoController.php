<?php

namespace App\Http\Controllers;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function store(Request $request) {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'video' => 'required|mimes:mp4,mov,avi|max:10240',
        ]);

        // Get the uploaded file
        $file = $request->file('video');

        // Generate a unique file name for the video
        $fileName = time() . '.' . $file->getClientOriginalExtension();

        // Define the path where the video will be stored
        $path = public_path('uploads/videos');

        // Ensure the directory exists, if not create it
        if (!file_exists($path)) {
            mkdir($path, 0775, true); // 0775 gives the right permissions
        }

        // Move the uploaded file to the uploads/videos folder
        $file->move($path, $fileName);

        // Save the file path to the database
        Video::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'video_path' => 'uploads/videos/' . $fileName,
            'tags' => json_encode($request->tags), // Store tags as JSON
        ]);

        return redirect()->back();
    }

}
