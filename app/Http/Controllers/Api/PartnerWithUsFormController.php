<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\PartnerWithUsAdminMail;
use App\Mail\PartnerWithUsCustomerMail;
use App\Models\PartnerWithUsForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PartnerWithUsFormController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'companyName' => 'required|string|max:255',
            'street' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip' => 'required|string',
            'name' => 'required|string|max:255',
            'job' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string',
            'yearsInBusiness' => 'required|string',
            'monthlySales' => 'required|string',
            'saleOtherCarriers' => 'required|string',
            'targetMarket' => 'required|string',
            'preferredPartnershipModel' => 'required|string',
            'billingContact' => 'required|string',
            'billingEmail' => 'required|email',
            'preferredShippingMethod' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $form = PartnerWithUsForm::create([
            'company_name' => $request->companyName,
            'website' => $request->website,
            'street' => $request->street,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'name' => $request->name,
            'job' => $request->job,
            'email' => $request->email,
            'countrycode' => $request->countrycode,
            'phone' => $request->phone,
            'years_in_business' => $request->yearsInBusiness,
            'monthly_sales' => $request->monthlySales,
            'business_types' => $request->businessTypes,
            'solutions' => $request->solutions,
            'sale_other_carriers' => $request->saleOtherCarriers,
            'target_market' => $request->targetMarket,
            'preferred_partnership_model' => $request->preferredPartnershipModel,
            'bank_transfer' => $request->bankTransfer,
            'billing_contact' => $request->billingContact,
            'billing_email' => $request->billingEmail,
            'preferred_shipping_method' => $request->preferredShippingMethod,
            'agree_eligibility' => $request->agreeEligibility ?? false,
            'agree_terms' => $request->agreeTerms ?? false,
        ]);

        // ✅ Send emails
        try {
            Mail::to($form->email)->send(new PartnerWithUsCustomerMail($form));
            Mail::to('support@zoikomobile.com')->send(new PartnerWithUsAdminMail($form));
        } catch (\Exception $e) {
            // Optional: Log mail errors
            \Log::error('Mail sending failed: ' . $e->getMessage());
        }

        return response()->json([
            'message' => 'Form submitted successfully',
            'data' => $form,
        ], 201);
    }
}
