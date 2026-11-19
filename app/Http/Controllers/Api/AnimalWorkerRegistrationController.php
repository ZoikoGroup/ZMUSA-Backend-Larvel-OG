<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AnimalWorkerRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use App\Mail\AnimalWorkerRegistrationMail;

class AnimalWorkerRegistrationController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'fname' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'countrycode' => 'nullable|string|max:10',
                'phone' => 'required|string|max:30',
                'dob' => 'required|date',
                'statusproof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
                'orgname' => 'required|string|max:255',
                'jobtitle' => 'required|string|max:255',
                'street' => 'required|string|max:255',
                'apprt' => 'nullable|string|max:255',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'zipcode' => 'required|string|max:20',
                'concent' => 'required|boolean',
                'terms' => 'required|boolean',
                'updates' => 'nullable|boolean',
                'familyMembers' => 'nullable|array|max:5',
                'familyMembers.*.famname' => 'nullable|string|max:255',
                'familyMembers.*.famemail' => 'nullable|email|max:255',
                'familyMembers.*.famphone' => 'nullable|string|max:30',
                'familyMembers.*.relation' => 'nullable|string|max:100',
                'rawjson' => 'nullable|string',
            ]);

            // ✅ Handle file upload
            $filePath = null;
            if ($request->hasFile('statusproof')) {
                $filePath = $request->file('statusproof')->store('animal_worker_docs', 'public');
            }

            // ✅ Create record
            $record = AnimalWorkerRegistration::create([
                'fname' => $validated['fname'],
                'email' => $validated['email'],
                'countrycode' => $validated['countrycode'] ?? null,
                'phone' => $validated['phone'],
                'dob' => $validated['dob'],
                'statusproof' => $filePath,
                'orgname' => $validated['orgname'],
                'jobtitle' => $validated['jobtitle'],
                'street' => $validated['street'],
                'apprt' => $validated['apprt'] ?? null,
                'city' => $validated['city'],
                'state' => $validated['state'],
                'zipcode' => $validated['zipcode'],
                'concent' => $validated['concent'],
                'terms' => $validated['terms'],
                'updates' => $validated['updates'] ?? false,
                'family_members' => $validated['familyMembers'] ?? [],
                'rawjson' => json_decode($validated['rawjson'] ?? '{}', true),
            ]);

            // ✅ Send Emails (User + Admin)
            try {
                // Send confirmation to user
                Mail::to($record->email)->send(new AnimalWorkerRegistrationMail($record, false));

                // Send notification to admin
                Mail::to('info@zoikogruop.com')->send(new AnimalWorkerRegistrationMail($record, true));
            } catch (\Exception $mailError) {
                \Log::error('Animal Worker Registration mail failed: ' . $mailError->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Registration submitted successfully. Emails have been sent.',
                'data' => $record,
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
