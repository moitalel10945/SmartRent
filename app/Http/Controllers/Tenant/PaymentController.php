<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\MpesaService;
use Illuminate\Http\RedirectResponse;

class PaymentController extends Controller
{
    public function __construct(protected MpesaService $mpesaService)
    {
    }

    public function store(): RedirectResponse
    {
        $user = auth()->user();
        $tenancy = $user->tenancies()->where('active', true)->with('unit')->first();

        if (!$tenancy) {
            return back()->with('error', 'No active tenancy found.');
        }

        if (!$tenancy->unit) {
            return back()->with('error', 'Unit information not found. Please contact your landlord.');
        }

        if (!$user->phone) {
            return back()->with('error', 'Your account has no phone number. Please contact your landlord.');
        }

        $existingPending = Payment::where('tenancy_id', $tenancy->id)
        ->where('status', 'pending')
        ->exists();

        $existingPending = Payment::where('tenancy_id', $tenancy->id)
        ->where('status', 'pending')
        ->exists();

        $phone  = $user->phone;
        $amount = (int) $tenancy->unit->rent_amount;

        if ($amount <= 0) {
            return back()->with('error', 'Invalid rent amount. Please contact your landlord.');
        }

        // Create payment record BEFORE calling API
        $payment = Payment::create([
            'tenancy_id' => $tenancy->id,
            'amount'     => $amount,
            'phone'      => $phone,
            'status'     => 'pending',
        ]);

        try {
            $response = $this->mpesaService->stkPush(
                phone: $phone,
                amount: $amount,
                reference: 'RENT-' . $tenancy->id
            );

            // Store identifiers returned by Safaricom
            $payment->update([
                'merchant_request_id'  => $response['MerchantRequestID'],
                'checkout_request_id'  => $response['CheckoutRequestID'],
            ]);

            return back()->with('success', 'Payment prompt sent to your phone. Enter your M-Pesa PIN to complete.');

        } catch (\Exception $e) {
            $payment->update(['status' => 'failed', 'failure_reason' => $e->getMessage()]);

            return back()->with('error', 'Could not initiate payment. Please try again.');
        }
    }
}