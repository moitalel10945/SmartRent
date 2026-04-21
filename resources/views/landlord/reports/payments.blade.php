<x-landlord>
  <div class="mb-6 flex items-center justify-between">
      <div>
          <h1 class="text-xl font-semibold text-gray-900">Payment Report</h1>
          <p class="text-sm text-gray-500 mt-1">Transaction history across your properties</p>
      </div>
      <a href="{{ route('landlord.reports.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
          ← All reports
      </a>
  </div>

  {{-- Filters --}}
  <div class="bg-white rounded-lg border border-gray-100 p-4 mb-6">
      <form method="GET" action="{{ route('landlord.reports.payments') }}"
            class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end">
          <div>
              <label class="block text-xs text-gray-500 mb-1">Status</label>
              <select name="status" class="w-full border border-gray-200 rounded px-3 py-2 text-sm">
                  <option value="">All</option>
                  <option value="completed" {{ ($filters['status'] ?? '') === 'completed' ? 'selected' : '' }}>Completed</option>
                  <option value="pending"   {{ ($filters['status'] ?? '') === 'pending'   ? 'selected' : '' }}>Pending</option>
                  <option value="failed"    {{ ($filters['status'] ?? '') === 'failed'    ? 'selected' : '' }}>Failed</option>
              </select>
          </div>
          <div>
              <label class="block text-xs text-gray-500 mb-1">Property</label>
              <select name="property_id" class="w-full border border-gray-200 rounded px-3 py-2 text-sm">
                  <option value="">All properties</option>
                  @foreach($properties as $property)
                      <option value="{{ $property->id }}"
                          {{ ($filters['property_id'] ?? '') == $property->id ? 'selected' : '' }}>
                          {{ $property->name }}
                      </option>
                  @endforeach
              </select>
          </div>
          <div>
              <label class="block text-xs text-gray-500 mb-1">From</label>
              <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}"
                  class="w-full border border-gray-200 rounded px-3 py-2 text-sm">
          </div>
          <div>
              <label class="block text-xs text-gray-500 mb-1">To</label>
              <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}"
                  class="w-full border border-gray-200 rounded px-3 py-2 text-sm">
          </div>
          <div class="flex gap-2">
              <button type="submit"
                  class="flex-1 bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium px-4 py-2 rounded transition">
                  Filter
              </button>
              <a href="{{ route('landlord.reports.payments') }}"
                  class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium px-4 py-2 rounded transition">
                  Reset
              </a>
          </div>
      </form>
  </div>

  <div class="flex justify-end mb-4">
    <a href="{{ route('landlord.reports.payments.export', request()->query()) }}"
       class="bg-white border border-gray-200 hover:border-gray-400 text-gray-700 text-sm font-medium px-4 py-2 rounded-lg transition">
        Export CSV
    </a>
</div>

  {{-- Summary cards --}}
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
      <x-stat-card label="Total transactions" :value="$report['total_count']" />
      <x-stat-card label="Total collected" :value="'KES ' . number_format($report['total_collected'], 2)" color="green" />
      <x-stat-card label="Failed payments" :value="$report['total_failed']" :color="$report['total_failed'] > 0 ? 'red' : 'gray'" />
  </div>

  {{-- Table --}}
  @if($report['payments']->isEmpty())
      <div class="bg-white rounded-lg border border-gray-100 px-6 py-10 text-center">
          <p class="text-gray-400 text-sm">No payment records found for the selected filters.</p>
      </div>
  @else
      <x-table-wrapper>
          <table class="w-full text-sm text-left">
              <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                  <tr>
                      <th class="px-6 py-3">Date</th>
                      <th class="px-6 py-3">Tenant</th>
                      <th class="px-6 py-3">Property</th>
                      <th class="px-6 py-3">Unit</th>
                      <th class="px-6 py-3">Amount</th>
                      <th class="px-6 py-3">M-Pesa ref</th>
                      <th class="px-6 py-3">Status</th>
                  </tr>
              </thead>
              <tbody class="divide-y divide-gray-50">
                  @foreach($report['payments'] as $payment)
                      <tr class="hover:bg-gray-50">
                          <td class="px-6 py-4 text-gray-600">
                              {{ $payment->created_at->format('d M Y') }}
                          </td>
                          <td class="px-6 py-4 font-medium text-gray-900">
                              {{ $payment->tenancy->tenant->name }}
                          </td>
                          <td class="px-6 py-4 text-gray-600">
                              {{ $payment->tenancy->unit->property->name }}
                          </td>
                          <td class="px-6 py-4 text-gray-600">
                              {{ $payment->tenancy->unit->unit_number }}
                          </td>
                          <td class="px-6 py-4 font-medium text-gray-900">
                              KES {{ number_format($payment->amount, 2) }}
                          </td>
                          <td class="px-6 py-4 text-gray-600">
                              {{ $payment->mpesa_receipt ?? '—' }}
                          </td>
                          <td class="px-6 py-4">
                              <x-status-badge :status="$payment->status" />
                          </td>
                      </tr>
                  @endforeach
              </tbody>
          </table>
      </x-table-wrapper>
  @endif

</x-landlord>