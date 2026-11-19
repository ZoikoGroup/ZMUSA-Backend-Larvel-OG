<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BecomeRetailerForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BecomeRetailerFormController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'companyName' => 'required|string|max:255',
            'website' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'job' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'countrycode' => 'nullable|string|max:10',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|string|max:50',
            'businessTypes' => 'array',
            'marketingChannels' => 'array',
            'planToPromotes' => 'array',
            'monthlyTraffic' => 'required|string|max:255',
            'promotoBrands' => 'required|string|max:255',
            'monthlyActivations' => 'required|string|max:255',
            'agreeEligibility' => 'boolean',
            'agreeTerms' => 'boolean',
        ]);

        $form = BecomeRetailerForm::create($validated);

        // ✅ Send emails
        $adminEmail = config('mail.admin_address', 'support@zoikomobile.com');

        // Mail to Admin
        Mail::send('emails.become_retailer_admin', ['form' => $form], function ($message) use ($adminEmail) {
            $message->to($adminEmail)
                    ->subject('🆕 New Become Affiliate Submission');
        });

        // Mail to User
        Mail::send('emails.become_retailer_user', ['form' => $form], function ($message) use ($form) {
            $message->to($form->email)
                    ->subject('✅ Thank You for Your Application - Zoiko Mobile');
        });

        return response()->json([
            'success' => true,
            'message' => 'Form submitted successfully.',
        ]);
    }
}
