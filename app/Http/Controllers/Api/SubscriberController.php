<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class SubscriberController extends Controller
{
    public function subscribe(Request $request)
    {
        // Validate email
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:subscribers,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        // Save subscriber
        $subscriber = Subscriber::create([
            'email' => $request->email,
        ]);

        // Send email to user
        Mail::raw("Thank you for subscribing to Zoiko Mobile updates!", function ($message) use ($subscriber) {
            $message->to($subscriber->email)
                ->subject("Subscription Successful");
        });

        // Send email to admin
        Mail::raw("New subscriber: {$subscriber->email}", function ($message) {
            $message->to('info@zoikogroup.com') // Replace with your admin email
                ->subject("New Subscriber Alert");
        });

        return response()->json([
            'success' => true,
            'message' => 'Thank you for subscribing! Emails sent.',
        ]);
    }
}
