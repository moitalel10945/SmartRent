<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Property;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $landlord    = auth()->user();
        $propertyIds = $landlord->properties()->pluck('id');

        // Base query — scoped to landlord's properties only
        $query = Payment::with(['tenancy.unit.property', 'tenancy.tenant'])
            ->whereHas('tenancy.unit', function ($q) use ($propertyIds) {
                $q->whereIn('property_id', $propertyIds);
            });

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by property
        if ($request->filled('property_id')) {
            $query->whereHas('tenancy.unit', function ($q) use ($request) {
                $q->where('property_id', $request->property_id);
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sorting
        $sort  = $request->input('sort', 'desc');
        $query->orderBy('created_at', $sort === 'asc' ? 'asc' : 'desc');

        $payments   = $query->paginate(20)->withQueryString();
        $properties = $landlord->properties()->orderBy('name')->get();

        return view('landlord.payments.index', compact('payments', 'properties'));
    }
}