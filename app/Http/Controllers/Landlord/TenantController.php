<?php

namespace App\Http\Controllers\Landlord;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = User::where('role', 'tenant')
            ->whereHas('tenancies.unit.property', function ($q) {
                $q->where('landlord_id', auth()->id());
            })
            ->orWhere(function ($q) {
                $q->where('role', 'tenant')
                  ->whereDoesntHave('tenancies');
            })
            ->withCount('tenancies')
            ->latest()
            ->get();

        return view('landlord.tenants.index', compact('tenants'));
    }

    public function create()
    {
        return view('landlord.tenants.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'phone'    => ['required', 'string', 'regex:/^(?:\+254|0)[17]\d{8}$/'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'tenant',
        ]);

        return redirect()
            ->route('landlord.tenants.index')
            ->with('success', 'Tenant account created successfully.');
    }
}