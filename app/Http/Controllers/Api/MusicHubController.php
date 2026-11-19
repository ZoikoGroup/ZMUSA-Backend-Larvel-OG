<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MusicHubRegistration;

class MusicHubController extends Controller
{
    public function store(Request $request)
    {
        try {

            // ✅ Validate incoming request
            $request->validate([
                'fname' => 'required|string|max:255',
                'email' => 'required|email',
                'countrycode' => 'required|string|max:10',
                'phone' => 'required|string|max:20',
                'desc' => 'nullable|string|max:255',
                'statusproof' => 'nullable|file|max:5120', // 5MB
            ]);

            // ✅ Upload file if exists
            $filePath = null;
            if ($request->hasFile('statusproof')) {
                $filePath = $request->file('statusproof')->store('music_hub', 'public');
            }

            // ✅ Save directly from request (NO JSON decoding)
            $record = MusicHubRegistration::create([
                'fname' => $request->fname,
                'email' => $request->email,
                'countrycode' => $request->countrycode,
                'phone' => $request->phone,
                'statusproof' => $filePath,
                'desc' => $request->desc,

                'perks' => $request->perks ?? 0,
                'discount' => $request->discount ?? 0,
                'tools' => $request->tools ?? 0,
                'storage' => $request->storage ?? 0,
                'access' => $request->access ?? 0,

                'other' => $request->other,
                'musicjourney' => $request->musicjourney,

                'concent' => $request->concent ?? 0,
                'terms' => $request->terms ?? 0,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Music Hub registration submitted successfully',
                'data' => $record
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}