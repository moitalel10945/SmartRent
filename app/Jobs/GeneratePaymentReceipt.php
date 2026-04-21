<?php

namespace App\Jobs;

use App\Models\Payment;
use App\Services\ReceiptService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GeneratePaymentReceipt implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(public Payment $payment)
    {
    }

    public function handle(ReceiptService $receiptService): void
    {
        $receiptService->generateForPayment($this->payment);
    }

    public function failed(\Throwable $exception): void
    {
        Log::channel('daily')->error('GeneratePaymentReceipt job failed permanently', [
            'payment_id' => $this->payment->id,
            'error'      => $exception->getMessage(),
        ]);
    }
}