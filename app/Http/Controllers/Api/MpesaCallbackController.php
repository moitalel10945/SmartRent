<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessMpesaCallback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MpesaCallbackController extends Controller
{
    public function handle(Request $request)
    {
        Log::channel('daily')->info('M-Pesa callback received', [
            'checkout_request_id' => $request->input('Body.stkCallback.CheckoutRequestID', 'unknown'),
            'result_code'         => $request->input('Body.stkCallback.ResultCode', 'unknown'),
        ]);

        $data = $request->input('Body.stkCallback');

        if (!$data) {
            Log::channel('daily')->warning('M-Pesa callback rejected — missing stkCallback');
            return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Accepted']);
        }

        if (!isset($data['CheckoutRequestID'], $data['ResultCode'], $data['ResultDesc'])) {
            Log::channel('daily')->warning('M-Pesa callback rejected — missing required fields');
            return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Accepted']);
        }

        if (!is_int($data['ResultCode'])) {
            Log::channel('daily')->warning('M-Pesa callback rejected — invalid ResultCode type');
            return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Accepted']);
        }

        // Dispatch to queue — controller returns immediately
        ProcessMpesaCallback::dispatch($data);

        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Accepted']);
    }
}