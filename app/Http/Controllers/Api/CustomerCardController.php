<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerCardController extends Controller
{
    // Save a new card
    public function store(Request $request)
    {
        $request->validate([
            'card_number' => 'required|digits_between:13,19',
            'card_holder_name' => 'required|string|max:255',
            'exp_month' => 'required|digits_between:1,2',
            'exp_year' => 'required|digits:4',
            'cvv' => 'required|digits_between:3,4',
        ]);

        $user = Auth::user();
        $cardHash = hash('sha256', $request->card_number);

        // Check duplicate
        $existing = CustomerCard::where('user_id', $user->id)
            ->where('card_number_hash', $cardHash)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'This card is already saved.'
            ], 409);
        }

        $card = CustomerCard::create([
            'user_id' => $user->id,
            'card_holder_name' => $request->card_holder_name,
            'card_number' => $request->card_number,
            'cvv' => $request->cvv,
            'exp_month' => $request->exp_month,
            'exp_year' => $request->exp_year,
            'card_number_hash' => $cardHash,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Card saved successfully',
            'card' => [
                'id' => $card->id,
                'card_holder_name' => $card->card_holder_name,
                'last4' => substr($request->card_number, -4),
                'exp_month' => $card->exp_month,
                'exp_year' => $card->exp_year,
            ]
        ]);
    }

    // List saved cards (last 4 digits)
    public function index()
    {
        $user = Auth::user();
        $cards = CustomerCard::where('user_id', $user->id)->get();

        $data = $cards->map(function ($card) {
            return [
                'id' => $card->id,
                'card_holder_name' => $card->card_holder_name,
                'last4' => substr($card->card_number, -4),
                'exp_month' => $card->exp_month,
                'exp_year' => $card->exp_year,
            ];
        });

        return response()->json([
            'success' => true,
            'cards' => $data
        ]);
    }

    // Use card for payment (full details)
    public function useCard(Request $request)
    {
        $request->validate([
            'card_id' => 'required|exists:customer_cards,id',
        ]);

        $user = Auth::user();
        $card = CustomerCard::where('id', $request->card_id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'card' => [
                'card_number' => $card->card_number,
                'cvv' => $card->cvv,
                'exp_month' => $card->exp_month,
                'exp_year' => $card->exp_year,
                'card_holder_name' => $card->card_holder_name,
            ]
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $card = CustomerCard::where('id', $id)
                    //->where('user_id', $request->user()->id)
                    ->first();

        if (!$card) {
            return response()->json([
                'success' => false,
                'message' => 'Card not found or unauthorized.',
            ], 404);
        }

        $card->delete();

        return response()->json([
            'success' => true,
            'message' => 'Card deleted successfully.',
        ]);
    }
}
