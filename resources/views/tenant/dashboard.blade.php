<x-tenant>
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-900">Dashboard</h1>
        <p class="text-sm text-gray-500 mt-1">Your tenancy overview</p>
    </div>

    @if($tenancy)

        {{-- Balance cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <x-stat-card label="Monthly Rent" :value="'KES ' . number_format($tenancy->unit->rent_amount, 2)" />
            <x-stat-card label="Total Paid" :value="'KES ' . number_format($balance['paid_total'], 2)" color="green" />
            <x-stat-card
                label="Outstanding Balance"
                :value="'KES ' . number_format($balance['arrears'], 2)"
                :color="$balance['is_owing'] ? 'red' : 'green'" />
        </div>

        {{-- Status banner --}}
        @if($balance['is_paid_up'])
            <div class="flex items-center gap-3 bg-green-50 border border-green-100 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">
                Your rent is up to date.
            </div>
        @else
            <div class="flex items-center gap-3 bg-red-50 border border-red-100 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">
                You have an outstanding balance of
                <strong>KES {{ number_format($balance['arrears'], 2) }}</strong>
                covering {{ $balance['months_elapsed'] }} month(s).
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Rental details --}}
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <p class="text-sm font-medium text-gray-700 mb-4">Rental details</p>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Property</dt>
                        <dd class="font-medium text-gray-900">{{ $tenancy->unit->property->name }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Location</dt>
                        <dd class="font-medium text-gray-900">{{ $tenancy->unit->property->location }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Unit</dt>
                        <dd class="font-medium text-gray-900">{{ $tenancy->unit->unit_number }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Status</dt>
                        <dd><x-status-badge :status="$tenancy->unit->status" /></dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Since</dt>
                        <dd class="font-medium text-gray-900">
                            {{ \Carbon\Carbon::parse($tenancy->start_date)->format('d M Y') }}
                        </dd>
                    </div>
                </dl>
            </div>

            {{-- Pay rent --}}
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <p class="text-sm font-medium text-gray-700 mb-4">Pay rent</p>

                @if(session('success'))
                    <div class="mb-4 bg-green-50 border border-green-100 text-green-700 px-4 py-3 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-50 border border-red-100 text-red-700 px-4 py-3 rounded-lg text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                <p class="text-sm text-gray-500 mb-4">
                    Amount due:
                    <span class="font-semibold text-gray-900">
                        KES {{ number_format($tenancy->unit->rent_amount, 2) }}
                    </span>
                </p>

                <form method="POST" action="{{ route('tenant.payment.store') }}"
                      onsubmit="this.querySelector('button').disabled = true">
                    @csrf
                    <button type="submit"
                        class="w-full bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium px-6 py-2.5 rounded-lg transition disabled:opacity-50">
                        Pay via M-Pesa
                    </button>
                </form>

                <p class="text-xs text-gray-400 mt-3 text-center">
                    You will receive an M-Pesa prompt on your phone.
                </p>
            </div>

        </div>

    @else
        <div class="bg-white rounded-lg border border-gray-100 px-6 py-12 text-center">
            <p class="text-gray-500 text-sm">You are not currently assigned to a unit.</p>
            <p class="text-gray-400 text-xs mt-1">Please contact your landlord to get assigned.</p>
        </div>
    @endif

</x-tenant>