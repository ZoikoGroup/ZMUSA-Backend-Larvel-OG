<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BecomeAffiliateForm;
use Illuminate\Support\Facades\Mail;

class BecomeAffiliateFormController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'companyName' => 'required|string|max:255',
            'businessType' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'job' => 'nullable|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:50',
            'countrycode' => 'nullable|string|max:10',
            'street' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:50',
            'yearsInBusiness' => 'nullable|string|max:255',
            'monthlySales' => 'nullable|string|max:255',
            'estimatedMonthlyPurchase' => 'nullable|string|max:255',
            'businessTypes' => 'nullable|array',
            'saleOtherCarriers' => 'nullable|string|max:255',
            'planToSell' => 'nullable|array',
            'bankTransfer' => 'nullable|string|max:255',
            'billingContact' => 'nullable|string|max:255',
            'billingEmail' => 'nullable|email|max:255',
            'preferredShippingMethod' => 'nullable|string|max:255',
            'agreeEligibility' => 'boolean',
            'agreeTerms' => 'boolean',
        ]);

        // Save to database
        $form = BecomeAffiliateForm::create([
            'company_name' => $data['companyName'],
            'business_type' => $data['businessType'] ?? null,
            'name' => $data['name'],
            'job' => $data['job'] ?? null,
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'countrycode' => $data['countrycode'] ?? null,
            'street' => $data['street'] ?? null,
            'city' => $data['city'] ?? null,
            'state' => $data['state'] ?? null,
            'zip' => $data['zip'] ?? null,
            'years_in_business' => $data['yearsInBusiness'] ?? null,
            'monthly_sales' => $data['monthlySales'] ?? null,
            'estimated_monthly_purchase' => $data['estimatedMonthlyPurchase'] ?? null,
            'business_types' => $data['businessTypes'] ?? [],
            'sale_other_carriers' => $data['saleOtherCarriers'] ?? null,
            'plan_to_sell' => $data['planToSell'] ?? [],
            'bank_transfer' => $data['bankTransfer'] ?? null,
            'billing_contact' => $data['billingContact'] ?? null,
            'billing_email' => $data['billingEmail'] ?? null,
            'preferred_shipping_method' => $data['preferredShippingMethod'] ?? null,
            'agree_eligibility' => $data['agreeEligibility'] ?? false,
            'agree_terms' => $data['agreeTerms'] ?? false,
        ]);

        // Send email notifications
        try {
            $adminEmail = config('mail.from.address', 'support@zoikomobile.com');

            // Email to admin
            Mail::raw("New retailer form submitted by {$form->name} ({$form->email})", function ($message) use ($adminEmail) {
                $message->to($adminEmail)->subject('New retailer Application');
            });

            // Email to user
            Mail::raw("Thank you {$form->name} for applying to become a Zoiko Mobile retailer. We will contact you soon.", function ($message) use ($form) {
                $message->to($form->email)->subject('Zoiko Mobile Retailer Application Received');
            });
        } catch (\Exception $e) {
            // Do not block request if mail fails
        }

        return response()->json([
            'success' => true,
            'message' => 'Application submitted successfully',
            'data' => $form,
        ], 201);
    }
}
