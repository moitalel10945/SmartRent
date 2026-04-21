<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Receipt;
use Illuminate\Http\Request;

class PaymentHistoryController extends Controller
{
    public function index(Request $request)
    {
        $tenancyIds = auth()->user()->tenancies()->pluck('id');

        // Base query — scoped to this tenant's tenancies only
        $query = Payment::with(['tenancy.unit.property', 'receipt'])
            ->whereIn('tenancy_id', $tenancyIds);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sorting
        $sort = $request->input('sort', 'desc');
        $query->orderBy('created_at', $sort === 'asc' ? 'asc' : 'desc');

        $payments = $query->paginate(15)->withQueryString();

        return view('tenant.payments.index', compact('payments'));
    }

    public function show(Receipt $receipt)
    {
        $tenancyIds = auth()->user()->tenancies()->pluck('id');

        abort_if(
            !$tenancyIds->contains($receipt->payment->tenancy_id),
            403
        );

        return view('tenant.payments.receipt', compact('receipt'));
    }
}