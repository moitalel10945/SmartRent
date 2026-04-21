<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MpesaService
{
    protected string $baseUrl;
    protected string $consumerKey;
    protected string $consumerSecret;
    protected string $shortcode;
    protected string $passkey;
    protected string $callbackUrl;

    public function __construct()
    {
        $this->baseUrl       = config('mpesa.base_url');
        $this->consumerKey   = config('mpesa.consumer_key');
        $this->consumerSecret = config('mpesa.consumer_secret');
        $this->shortcode     = config('mpesa.shortcode');
        $this->passkey       = config('mpesa.passkey');
        $this->callbackUrl   = config('mpesa.callback_url');
    }

    public function getAccessToken(): string
    {
        $credentials = base64_encode($this->consumerKey . ':' . $this->consumerSecret);

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $credentials,
        ])->get($this->baseUrl . '/oauth/v1/generate', [
            'grant_type' => 'client_credentials',
        ]);

        if ($response->failed()) {
            Log::error('M-Pesa token error', ['response' => $response->body()]);
            throw new \Exception('Could not retrieve M-Pesa access token.');
        }

        return $response->json('access_token');
    }

    public function stkPush(string $phone, int $amount, string $reference): array
    {
        $token     = $this->getAccessToken();
        $timestamp = now()->format('YmdHis');
        $password  = base64_encode($this->shortcode . $this->passkey . $timestamp);
        $phone     = $this->formatPhone($phone);

        $response = Http::withToken($token)
            ->post($this->baseUrl . '/mpesa/stkpush/v1/processrequest', [
                'BusinessShortCode' => $this->shortcode,
                'Password'          => $password,
                'Timestamp'         => $timestamp,
                'TransactionType'   => 'CustomerPayBillOnline',
                'Amount'            => $amount,
                'PartyA'            => $phone,
                'PartyB'            => $this->shortcode,
                'PhoneNumber'       => $phone,
                'CallBackURL'       => $this->callbackUrl,
                'AccountReference'  => $reference,
                'TransactionDesc'   => 'Rent payment for ' . $reference,
            ]);

        if ($response->failed()) {
            Log::error('M-Pesa STK error', ['response' => $response->body()]);
            throw new \Exception('STK Push request failed.');
        }

        return $response->json();
    }

    protected function formatPhone(string $phone): string
    {
        $phone = preg_replace('/\s+/', '', $phone);

        if (str_starts_with($phone, '0')) {
            return '254' . substr($phone, 1);
        }

        if (str_starts_with($phone, '+')) {
            return substr($phone, 1);
        }

        return $phone;
    }
}