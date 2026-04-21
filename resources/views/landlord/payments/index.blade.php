<x-landlord>
  <h1 class="text-2xl font-bold mb-6">Payment Records</h1>

  {{-- Filters --}}
  <div class="bg-white shadow rounded-lg p-4 mb-6">
      <form method="GET" action="{{ route('landlord.payments.index') }}"
            class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end">

          <div>
              <label class="block text-xs text-gray-500 mb-1">Status</label>
              <select name="status"
                  class="w-full border border-gray-200 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-300">
                  <option value="">All</option>
                  <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                  <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>Pending</option>
                  <option value="failed"    {{ request('status') === 'failed'    ? 'selected' : '' }}>Failed</option>
              </select>
          </div>

          <div>
              <label class="block text-xs text-gray-500 mb-1">Property</label>
              <select name="property_id"
                  class="w-full border border-gray-200 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-300">
                  <option value="">All Properties</option>
                  @foreach($properties as $property)
                      <option value="{{ $property->id }}"
                          {{ request('property_id') == $property->id ? 'selected' : '' }}>
                          {{ $property->name }}
                      </option>
                  @endforeach
              </select>
          </div>

          <div>
              <label class="block text-xs text-gray-500 mb-1">From</label>
              <input type="date" name="date_from" value="{{ request('date_from') }}"
                  class="w-full border border-gray-200 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-300">
          </div>

          <div>
              <label class="block text-xs text-gray-500 mb-1">To</label>
              <input type="date" name="date_to" value="{{ request('date_to') }}"
                  class="w-full border border-gray-200 rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-300">
          </div>

          <div class="flex gap-2">
              <button type="submit"
                  class="flex-1 bg-gray-800 hover:bg-gray-900 text-white text-sm font-medium px-4 py-2 rounded transition">
                  Filter
              </button>
              <a href="{{ route('landlord.payments.index') }}"
                  class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium px-4 py-2 rounded transition">
                  Reset
              </a>
          </div>

      </form>
  </div>

  {{-- Sort toggle --}}
  <div class="flex justify-end mb-3">
      <a href="{{ request()->fullUrlWithQuery(['sort' => request('sort', 'desc') === 'desc' ? 'asc' : 'desc']) }}"
         class="text-sm text-gray-500 hover:text-gray-700">
          Date {{ request('sort', 'desc') === 'desc' ? '↓ Newest first' : '↑ Oldest first' }}
      </a>
  </div>

  {{-- Table --}}
  @if($payments->isEmpty())
      <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-4 rounded">
          No payment records found.
      </div>
  @else
      <div class="bg-white shadow rounded-lg overflow-hidden mb-4">
          <table class="w-full text-sm text-left">
              <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                  <tr>
                      <th class="px-6 py-3">Date</th>
                      <th class="px-6 py-3">Tenant</th>
                      <th class="px-6 py-3">Property</th>
                      <th class="px-6 py-3">Unit</th>
                      <th class="px-6 py-3">Amount</th>
                      <th class="px-6 py-3">M-Pesa Ref</th>
                      <th class="px-6 py-3">Status</th>
                  </tr>
              </thead>
              <tbody class="divide-y divide-gray-100">
                  @foreach($payments as $payment)
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
                              @if($payment->status === 'completed')
                                  <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-medium">
                                      Completed
                                  </span>
                              @elseif($payment->status === 'failed')
                                  <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-medium">
                                      Failed
                                  </span>
                              @else
                                  <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-medium">
                                      Pending
                                  </span>
                              @endif
                          </td>
                      </tr>
                  @endforeach
              </tbody>
          </table>
      </div>

      {{-- Pagination --}}
      {{ $payments->links() }}
  @endif

</x-landlord>