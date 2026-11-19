<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BlackFridayAdminMail;
use App\Mail\BlackFridayUserMail;
use App\Models\BlackFridayFormSubmission;

class BlackFridayFormController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'firstName' => 'required|string|max:120',
            'lastName'  => 'required|string|max:120',
            'email'     => 'required|email',
            'company'   => 'required|string|max:255',
            'phone'     => 'required|string|max:50',
            'message'   => 'nullable|string',
        ]);

        // Save to database
        $submission = BlackFridayFormSubmission::create([
            'first_name' => $validated['firstName'],
            'last_name'  => $validated['lastName'],
            'email'      => $validated['email'],
            'company'    => $validated['company'],
            'phone'      => $validated['phone'],
            'message'    => $validated['message'] ?? null,
        ]);

        // Send mail to admin
        Mail::to('support@zoikomobile.com')
            ->send(new BlackFridayAdminMail($validated));

        // Send acknowledgement mail to user
        Mail::to($validated['email'])
            ->send(new BlackFridayUserMail($validated));

        return response()->json([
            'success' => true,
            'message' => 'Form submitted successfully!',
            'data'    => $submission
        ], 200);
    }
}
