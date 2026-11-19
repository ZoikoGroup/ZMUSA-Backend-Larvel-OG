<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StripeHook;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');

        // OPTIONAL config (won't fail if missing)
        $webhookSecret = config('services.stripe.webhook_secret')
            ?? env('STRIPE_WEBHOOK_SECRET');

        try {
            if ($webhookSecret && $signature) {
                $event = Webhook::constructEvent(
                    $payload,
                    $signature,
                    $webhookSecret
                );
            } else {
                // Fallback (no signature validation)
                $event = json_decode($payload);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Invalid Stripe webhook'
            ], 400);
        }

        // Prevent duplicate events
        if (!empty($event->id) &&
            StripeHook::where('event_id', $event->id)->exists()) {
            return response()->json(['status' => 'duplicate'], 200);
        }

        $object = $event->data->object ?? null;

        StripeHook::create([
            'event_id' => $event->id ?? uniqid('stripe_', true),
            'event_type' => $event->type ?? 'unknown',

            'payment_intent_id' => $object->payment_intent ?? null,
            'charge_id' => $object->id ?? null,
            'customer_id' => $object->customer ?? null,

            'status' => $object->status ?? null,
            'currency' => $object->currency ?? null,
            'amount' => isset($object->amount)
                ? $object->amount / 100
                : null,

            'payment_method_details' => $object->payment_method_details ?? null,
            'billing_details' => $object->billing_details ?? null,

            'raw_payload' => json_decode($payload, true),
        ]);

        return response()->json(['received' => true], Response::HTTP_OK);
    }
}
