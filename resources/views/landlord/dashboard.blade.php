<x-landlord>
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-gray-900">Dashboard</h1>
        <p class="text-sm text-gray-500 mt-1">Overview of your portfolio</p>
    </div>

    {{-- Summary cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <x-stat-card label="Properties" :value="$summary['total_properties']" />
        <x-stat-card label="Occupancy" :value="$summary['occupancy_rate'] . '%'" color="blue" />
        <x-stat-card label="Total Collected" :value="'KES ' . number_format($summary['total_collected'], 2)" color="green" />
        <x-stat-card label="Total Arrears" :value="'KES ' . number_format($summary['total_arrears'], 2)" :color="$summary['total_arrears'] > 0 ? 'red' : 'green'" />
    </div>

    {{-- Occupancy and payment status --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">

        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <p class="text-sm font-medium text-gray-700 mb-3">Occupancy</p>
            <div class="flex items-center gap-4 mb-3">
                <span class="text-3xl font-bold text-gray-900">{{ $summary['occupancy_rate'] }}%</span>
                <span class="text-sm text-gray-400">{{ $summary['occupied_units'] }} of {{ $summary['total_units'] }} units</span>
            </div>
            <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-2 rounded-full transition-all
                    {{ $summary['occupancy_rate'] >= 75 ? 'bg-green-500' : ($summary['occupancy_rate'] >= 50 ? 'bg-yellow-400' : 'bg-red-400') }}"
                    style="width: {{ $summary['occupancy_rate'] }}%">
                </div>
            </div>
            <div class="flex gap-4 mt-3 text-xs text-gray-500">
                <span>{{ $summary['occupied_units'] }} occupied</span>
                <span>{{ $summary['vacant_units'] }} vacant</span>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <p class="text-sm font-medium text-gray-700 mb-3">Tenant payment status</p>
            <div class="flex gap-8 mt-4">
                <div>
                    <p class="text-3xl font-bold text-green-600">{{ $summary['tenants_paid_up'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">Paid up</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-red-600">{{ $summary['tenants_owing'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">Owing</p>
                </div>
            </div>
        </div>

    </div>

    {{-- Active tenants table --}}
    <div class="mb-2 flex items-center justify-between">
        <p class="text-sm font-medium text-gray-700">Active tenants</p>
        <a href="{{ route('landlord.arrears.index') }}" class="text-xs text-blue-600 hover:underline">
            View full arrears report
        </a>
    </div>

    @if(count($summary['tenant_summary']) > 0)
        <x-table-wrapper>
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                    <tr>
                        <th class="px-6 py-3">Tenant</th>
                        <th class="px-6 py-3">Property</th>
                        <th class="px-6 py-3">Unit</th>
                        <th class="px-6 py-3">Rent</th>
                        <th class="px-6 py-3">Paid</th>
                        <th class="px-6 py-3">Arrears</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($summary['tenant_summary'] as $row)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $row['tenancy']->tenant->name }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $row['tenancy']->unit->property->name }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $row['tenancy']->unit->unit_number }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                KES {{ number_format($row['tenancy']->unit->rent_amount, 2) }}
                            </td>
                            <td class="px-6 py-4 text-green-600 font-medium">
                                KES {{ number_format($row['balance']['paid_total'], 2) }}
                            </td>
                            <td class="px-6 py-4 font-medium {{ $row['balance']['is_owing'] ? 'text-red-600' : 'text-green-600' }}">
                                KES {{ number_format($row['balance']['arrears'], 2) }}
                            </td>
                            <td class="px-6 py-4">
                                <x-status-badge :status="$row['balance']['is_paid_up'] ? 'completed' : 'failed'" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-table-wrapper>
    @else
        <div class="bg-white rounded-lg border border-gray-100 px-6 py-10 text-center">
            <p class="text-gray-400 text-sm">No active tenants found.</p>
            <a href="{{ route('landlord.tenancies.create') }}"
               class="inline-block mt-3 text-sm text-blue-600 hover:underline">
                Assign a tenant
            </a>
        </div>
    @endif

</x-landlord>