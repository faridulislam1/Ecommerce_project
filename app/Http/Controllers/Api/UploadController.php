<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:5120', // 5MB
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
            $url = asset('storage/' . $path);
            return response()->json([
                'url' => $url,
                'path' => $path,
            ]);
        }

        return response()->json(['message' => 'No image uploaded'], 400);
    }
}

