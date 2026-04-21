<?php

namespace App\Services;

use App\Jobs\GeneratePaymentReceipt;
use App\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentVerificationService
{
    public function process(array $data): void
    {
        $checkoutRequestId = $data['CheckoutRequestID'];
        $resultCode        = $data['ResultCode'];
        $resultDesc        = $data['ResultDesc'];

        $payment = Payment::where('checkout_request_id', $checkoutRequestId)->first();

        if (!$payment) {
            Log::channel('daily')->warning('M-Pesa callback — no matching payment found', [
                'checkout_request_id' => $checkoutRequestId,
            ]);
            return;
        }

        if (!$payment->isPending()) {
            Log::channel('daily')->info('M-Pesa callback — payment already processed, skipping', [
                'checkout_request_id' => $checkoutRequestId,
                'current_status'      => $payment->status,
            ]);
            return;
        }

        if ($resultCode === 0) {
            $this->handleSuccess($payment, $data);
        } else {
            $this->handleFailure($payment, $resultCode, $resultDesc);
        }
    }

    protected function handleSuccess(Payment $payment, array $data): void
    {
        if (empty($data['CallbackMetadata']['Item'])) {
            Log::channel('daily')->error('M-Pesa success callback missing metadata', [
                'checkout_request_id' => $payment->checkout_request_id,
            ]);
            return;
        }

        $metadata = collect($data['CallbackMetadata']['Item']);

        $amount          = $metadata->firstWhere('Name', 'Amount')['Value'];
        $receipt         = $metadata->firstWhere('Name', 'MpesaReceiptNumber')['Value'];
        $transactionDate = $metadata->firstWhere('Name', 'TransactionDate')['Value'];

        if ((int) $amount !== (int) $payment->amount) {
            Log::channel('daily')->error('M-Pesa callback — amount mismatch', [
                'expected' => $payment->amount,
                'received' => $amount,
                'receipt'  => $receipt,
            ]);
            return;
        }

        DB::transaction(function () use ($payment, $receipt, $transactionDate) {
            $payment->update([
                'status'        => 'completed',
                'mpesa_receipt' => $receipt,
                'paid_at'       => Carbon::createFromFormat('YmdHis', (string) $transactionDate),
            ]);

            GeneratePaymentReceipt::dispatch($payment->fresh());
        });

        Log::channel('daily')->info('M-Pesa payment completed and receipt dispatched', [
            'payment_id' => $payment->id,
            'receipt'    => $receipt,
            'amount'     => $amount,
        ]);
    }

    protected function handleFailure(Payment $payment, int $resultCode, string $resultDesc): void
    {
        $payment->update([
            'status'         => 'failed',
            'failure_reason' => $resultDesc,
        ]);

        Log::channel('daily')->warning('M-Pesa payment failed', [
            'payment_id'  => $payment->id,
            'result_code' => $resultCode,
            'result_desc' => $resultDesc,
        ]);
    }
}