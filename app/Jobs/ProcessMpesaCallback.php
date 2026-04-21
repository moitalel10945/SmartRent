<?php

namespace App\Jobs;

use App\Services\PaymentVerificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessMpesaCallback implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Retry up to 3 times if job fails
    public int $tries = 3;

    // Wait 60 seconds between retries
    public int $backoff = 60;

    public function __construct(public array $callbackData)
    {
    }

    public function handle(PaymentVerificationService $verificationService): void
    {
        $verificationService->process($this->callbackData);
    }

    public function failed(\Throwable $exception): void
    {
        Log::channel('daily')->error('ProcessMpesaCallback job failed permanently', [
            'checkout_request_id' => $this->callbackData['CheckoutRequestID'] ?? 'unknown',
            'error'               => $exception->getMessage(),
        ]);
    }
}