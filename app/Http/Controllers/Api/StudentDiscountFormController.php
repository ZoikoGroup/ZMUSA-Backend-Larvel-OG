<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentDiscountForm;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class StudentDiscountFormController extends Controller
{
    public function store(Request $request)
    {
        try {

            // 1️⃣ Validate Request
            $data = $request->validate([
                'fname' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'countrycode' => 'nullable|string|max:10',
                'phone' => 'required|string|max:20',
                'statusproof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
                'school' => 'required|string|max:255',
                'yos' => 'required|date',
                'keepnumber' => 'required|string|max:50',
                'plan' => 'required|string|max:50',
                'cat' => 'required|string|max:50',
                'concent' => 'required|boolean',
                'terms' => 'required|boolean',
            ]);

            // 2️⃣ Upload File
            if ($request->hasFile('statusproof')) {
                $data['statusproof'] = $request->file('statusproof')->store('student_ids', 'public');
            }

            // 3️⃣ Create Record (email not sent yet)
            $form = StudentDiscountForm::create([
                ...$data,
                'email_sent' => false,
            ]);

            // 4️⃣ Send Emails inside try/catch
            try {

                // 📩 Email to Admin
                Mail::send('emails.student_discount_admin', ['data' => $data], function ($message) use ($data) {
                    $message->to('support@zoikomobile.com')
                            ->subject('🎓 New Student Discount Application from ' . $data['fname']);
                });

                // 📩 Email to User
                Mail::send('emails.student_discount_user', ['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'])
                            ->subject('🎓 Thank You for Your Student Discount Application');
                });

                // 5️⃣ Update email_sent = TRUE
                $form->update([
                    'email_sent' => true
                ]);

            } catch (\Exception $mailError) {

                // Log email error but DON'T fail API
                Log::error('Student Discount Email Failed: ' . $mailError->getMessage());
            }

            // 6️⃣ Response
            return response()->json([
                'status' => true,
                'message' => 'Form submitted successfully.',
                'email_sent' => $form->email_sent,
                'data' => $form
            ], 201);

        } catch (\Exception $e) {

            Log::error('Student Discount Form Error: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong while submitting form.'
            ], 500);
        }
    }
}