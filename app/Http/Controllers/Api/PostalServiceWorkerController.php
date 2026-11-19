<?php

// app/Http/Controllers/Api/PostalServiceWorkerController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PostalServiceWorker;
use Illuminate\Http\Request;

class PostalServiceWorkerController extends Controller
{
    public function store(Request $request)
    {
        // Handle file upload if exists
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('postal-workers', 'public');
        }

        // Decode JSON data
        $data = json_decode($request->input('data'), true);

        // Save record
        $worker = PostalServiceWorker::create([
            'data' => $data,
            'file_path' => $filePath,
        ]);

        return response()->json([
            'message' => 'Postal Service Worker saved successfully!',
            'worker' => $worker,
        ]);
    }
}
