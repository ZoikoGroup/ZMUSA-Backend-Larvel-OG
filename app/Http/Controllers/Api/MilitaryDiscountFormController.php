<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MilitaryDiscountForm;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class MilitaryDiscountFormController extends Controller
{
    public function store(Request $request)
    {
        // 1️⃣ Validate request
        $data = $request->validate([
            'fname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'countrycode' => 'nullable|string|max:10',
            'phone' => 'required|string|max:20',
            'statusproof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'plan' => 'nullable|string|max:255',
            'cat' => 'nullable|string|max:255',
            'concent' => 'required|boolean',
            'terms' => 'required|boolean',
            'family' => 'nullable|array',
            'family.*.famname' => 'required|string|max:255',
            'family.*.famemail' => 'required|email|max:255',
            'family.*.famphone' => 'required|string|max:20',
            'family.*.famrelation' => 'required|string|max:255',
        ]);

        // 2️⃣ Upload file if exists
        if ($request->hasFile('statusproof')) {
            $data['statusproof'] = $request->file('statusproof')
                ->store('military_proofs', 'public');
        }

        // 3️⃣ Default email status = false
        $data['email_sent'] = false;

        // 4️⃣ Save form first (IMPORTANT)
        $form = MilitaryDiscountForm::create($data);

        // 5️⃣ Try sending emails safely
        try {

            $adminEmail = config('mail.admin_address', 'support@zoikomobile.com');

            // Applicant email
            Mail::raw(
                "Dear {$form->fname},\n\nThank you for submitting your Military & Veterans Discount form.\nWe will review your details and get back to you soon.\n\n- Zoiko Mobile Team",
                function ($message) use ($form) {
                    $message->to($form->email)
                        ->subject('Your Military Discount Form Submission');
                }
            );

            // Admin email
            Mail::raw(
                "New Military & Veterans Discount Application:\n\nName: {$form->fname}\nEmail: {$form->email}\nPhone: {$form->phone}\n\nCheck Filament panel for full details.",
                function ($message) use ($adminEmail) {
                    $message->to($adminEmail)
                        ->subject('New Military Discount Form Submission');
                }
            );

            // 6️⃣ If email success → update flag
            $form->update([
                'email_sent' => true
            ]);

        } catch (\Exception $e) {
            // ❗ Email failed but form saved successfully
            Log::error('Military form email failed: ' . $e->getMessage());
        }

        // 7️⃣ ALWAYS return success response
        return response()->json([
            'success' => true,
            'message' => 'Form submitted successfully.',
            'email_status' => $form->email_sent ? 'sent' : 'failed',
            'data' => $form,
        ], 201);
    }
}