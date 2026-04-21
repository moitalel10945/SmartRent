<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Receipt;
use Illuminate\Support\Carbon;

class ReceiptService
{
    public function generateForPayment(Payment $payment): Receipt
    {
        // Idempotency — never create two receipts for the same payment
        if ($payment->receipt) {
            return $payment->receipt;
        }

        $receiptNumber = $this->generateReceiptNumber();

        return Receipt::create([
            'payment_id'     => $payment->id,
            'receipt_number' => $receiptNumber,
            'amount'         => $payment->amount,
            'mpesa_receipt'  => $payment->mpesa_receipt,
            'phone'          => $payment->phone,
            'generated_at'   => Carbon::now(),
        ]);
    }

    protected function generateReceiptNumber(): string
    {
        // Format: SR-20240120-A3F9B2
        // SR = SmartRent prefix
        // Date = makes it human readable
        // Random hex = makes it unique and not guessable
        do {
            $number = 'SR-' . now()->format('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
        } while (Receipt::where('receipt_number', $number)->exists());

        return $number;
    }
}