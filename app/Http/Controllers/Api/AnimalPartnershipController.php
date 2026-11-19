<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnimalPartnership;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\AnimalPartnershipMail;

class AnimalPartnershipController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'orgname' => 'required|string|max:255',
            'orgtype' => 'required|string|max:255',
            'focus' => 'required|string|max:255',
            'website' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zipcode' => 'required|string|max:50',
            'mission' => 'required|string',
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->all();

        // Handle file upload (if any)
        if ($request->hasFile('statusproof')) {
            $file = $request->file('statusproof');
            $path = $file->store('statusproofs', 'public');
            $data['statusproof'] = $path;
        }

        $partnership = AnimalPartnership::create($data);

        // Send email to admin and user
        $adminEmail = 'info@zoikogroup.com';
        Mail::to($adminEmail)->send(new AnimalPartnershipMail($data, true));
        Mail::to($data['email'])->send(new AnimalPartnershipMail($data, false));

        return response()->json([
            'message' => 'Application submitted successfully. Confirmation email has been sent.',
            'data' => $partnership,
        ], 201);
    }
}
