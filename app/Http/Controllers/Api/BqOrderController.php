<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BqOrder;
use Illuminate\Http\Request;

class BqOrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'billingAddress' => 'nullable|array',
            'shippingAddress' => 'nullable|array',
            'shippingOption' => 'nullable|array',
            'cardAddress' => 'nullable|array',
            'cart' => 'nullable|array|min:1',
            'totals' => 'nullable|array',
            'agreedToTerms' => 'nullable|boolean',
            'payment_type_id' => 'nullable|integer',
            'subscriber_id' => 'nullable|integer',

            'coupon' => 'nullable|string',

            'payment_method_id' => 'nullable|integer',
            'address_id' => 'nullable|integer',
            'address_attributes' => 'nullable|array',
            'service_address_id' => 'nullable|integer',
            'line_id' => 'nullable|integer',
            'shipping_address_id' => 'nullable|integer',

            'bequick_order_id' => 'nullable|integer',
            'bequick_order_amount' => 'nullable|numeric',

            'cardDetails' => 'nullable|array',
        ]);

        // Prepare data for BqOrder model (UNCHANGED)
        $data = [
            'billing_address' => $validated['billingAddress'] ?? null,
            'shipping_address' => $validated['shippingAddress'] ?? null,
            'shipping_option' => $validated['shippingOption'] ?? null,

            'card_address' => $validated['cardAddress'] ?? null,
            'cart' => $validated['cart'] ?? null,
            'totals' => $validated['totals'] ?? null,

            'agreed_to_terms' => $validated['agreedToTerms'] ?? null,
            'payment_type_id' => $validated['payment_type_id'] ?? null,
            'subscriber_id' => $validated['subscriber_id'] ?? null,

            'coupon' => $validated['coupon'] ?? null,
            'payment_method_id' => $validated['payment_method_id'] ?? null,
            'address_id' => $validated['address_id'] ?? null,
            'address_attributes' => $validated['address_attributes'] ?? null,
            'service_address_id' => $validated['service_address_id'] ?? null,
            'line_id' => $validated['line_id'] ?? null,
            'shipping_address_id' => $validated['shipping_address_id'] ?? null,

            'bequick_order_id' => $validated['bequick_order_id'] ?? null,
            'bequick_order_amount' => $validated['bequick_order_amount'] ?? null,

            'card_details' => $validated['cardDetails'] ?? null,

            'raw_data' => json_encode($request->all()), // UNCHANGED
        ];

        $order = BqOrder::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully.',
            'order_id' => $order->id,
        ], 201);
    }

    public function index()
    {
        return response()->json(BqOrder::latest()->get());
    }

    public function show(BqOrder $bqorder)
    {
        return response()->json($bqorder);
    }
}
