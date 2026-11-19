<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    // Get all coupons (admin or user)
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return response()->json($coupons);
    }

    // Get single coupon by ID
    public function show($id)
    {
        $coupon = Coupon::find($id);
        if (!$coupon) {
            return response()->json(['message' => 'Coupon not found'], 404);
        }
        return response()->json($coupon);
    }

    // Get by coupon name (slug or name)
    public function getByName($name)
    {
        $coupon = Coupon::where('name', $name)->orWhere('slug', Str::slug($name))->first();
        if (!$coupon) {
            return response()->json(['message' => 'Coupon not found'], 404);
        }
        return response()->json($coupon);
    }

    // Create a new coupon
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:coupons,name',
            'discount' => 'required|numeric|min:0',
            'type' => 'required|in:flat,percentage',
            'limit' => 'nullable|integer',
            'related_product' => 'nullable|array',
            'related_plan' => 'nullable|array',
        ]);

        $coupon = Coupon::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'discount' => $validated['discount'],
            'type' => $validated['type'],
            'limit' => $validated['limit'] ?? null,
            'user_id' => Auth::id(),
            'related_product' => json_encode($validated['related_product'] ?? []),
            'related_plan' => json_encode($validated['related_plan'] ?? []),
        ]);

        return response()->json(['message' => 'Coupon created successfully', 'data' => $coupon]);
    }

    // Update coupon (User can only update their own)
    public function update(Request $request, $id)
    {
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json(['message' => 'Coupon not found'], 404);
        }

        if ($coupon->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'discount' => 'nullable|numeric|min:0',
            'type' => 'nullable|in:flat,percentage',
            'limit' => 'nullable|integer',
            'related_product' => 'nullable|array',
            'related_plan' => 'nullable|array',
        ]);

        $coupon->update([
            'name' => $validated['name'] ?? $coupon->name,
            'slug' => isset($validated['name']) ? Str::slug($validated['name']) : $coupon->slug,
            'discount' => $validated['discount'] ?? $coupon->discount,
            'type' => $validated['type'] ?? $coupon->type,
            'limit' => $validated['limit'] ?? $coupon->limit,
            'related_product' => isset($validated['related_product']) ? json_encode($validated['related_product']) : $coupon->related_product,
            'related_plan' => isset($validated['related_plan']) ? json_encode($validated['related_plan']) : $coupon->related_plan,
        ]);

        return response()->json(['message' => 'Coupon updated successfully', 'data' => $coupon]);
    }

    // Delete coupon (only by owner)
    public function destroy($id)
    {
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json(['message' => 'Coupon not found'], 404);
        }

        if ($coupon->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $coupon->delete();
        return response()->json(['message' => 'Coupon deleted successfully']);
    }

    public function apply(Request $request)
{
    $request->validate([
        'email'       => 'required|email',
        'coupon_code' => 'required|string',
        'user_id'     => 'nullable|exists:users,id',
    ]);

    // Get user by ID or email
    if ($request->filled('user_id')) {
        $user = \App\Models\User::find($request->user_id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], 404);
        }

        // Verify email matches user
        if ($user->email !== $request->email) {
            return response()->json([
                'success' => false,
                'message' => 'Email does not match the given user ID.'
            ], 422);
        }
    } else {
        // Lookup user by email if no ID provided
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'No user found with this email.'
            ], 404);
        }
    }

    // Case-insensitive coupon lookup
    $code = strtolower($request->coupon_code);

    $coupon = Coupon::whereRaw('LOWER(slug) = ?', [$code])
                    ->orWhereRaw('LOWER(name) = ?', [$code])
                    ->first();

    if (!$coupon) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid coupon code.'
        ], 404);
    }

    // If coupon is user-specific, ensure it belongs to this user
    if ($coupon->user_id && $coupon->user_id != $user->id) {
        return response()->json([
            'success' => false,
            'message' => 'This coupon is not valid for this user.'
        ], 403);
    }

    // Check coupon usage limit
    if ($coupon->limit && $coupon->used_count >= $coupon->limit) {
        return response()->json([
            'success' => false,
            'message' => 'Coupon usage limit reached.'
        ], 400);
    }

   // Check "use once per customer"
if ($coupon->is_use_once_per_customer == 1) {

    // normalized search code (lowercase)
    $code = strtolower($coupon->slug);

    $matches = \DB::table('bqorders')
        ->select(
            'id',
            \DB::raw("JSON_UNQUOTE(JSON_EXTRACT(billing_address, '$.email')) as billing_email")
        )
        ->whereNotNull('coupon')
        ->where(function ($q) use ($code) {
            // coupon stored as JSON with key "code"
            $q->whereRaw("JSON_VALID(coupon) AND LOWER(JSON_UNQUOTE(JSON_EXTRACT(coupon, '$.code'))) = ?", [$code])
              // or coupon stored as JSON with key "slug"
              ->orWhereRaw("JSON_VALID(coupon) AND LOWER(JSON_UNQUOTE(JSON_EXTRACT(coupon, '$.slug'))) = ?", [$code])
              // or coupon stored as plain string
              ->orWhereRaw("NOT JSON_VALID(coupon) AND LOWER(coupon) = ?", [$code]);
        })
        // ensure billing_address has the same email (case-insensitive)
        ->whereRaw("JSON_VALID(billing_address) AND LOWER(JSON_UNQUOTE(JSON_EXTRACT(billing_address, '$.email'))) = ?", [strtolower($user->email)])
        ->get();

    if ($matches->isNotEmpty()) {
        // prepare a simple array of matches to return (order id + email)
        $seen = $matches->map(fn($m) => [
            'order_id' => $m->id,
            'billing_email' => $m->billing_email,
        ])->values();

        return response()->json([
            'success' => false,
            'message' => 'You have already used this coupon.',
            'matches' => $seen,
        ], 403);
    }
}



    return response()->json([
        'success' => true,
        'message' => 'Coupon is valid.',
        'data' => [
            'coupon_code' => $coupon->slug,
            'discount'    => $coupon->discount,
            'type'        => $coupon->type,
            'user_id'     => $user->id,
            'user_email'  => $user->email,
        ]
    ]);
}




}
