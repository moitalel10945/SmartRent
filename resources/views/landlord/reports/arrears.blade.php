<x-landlord>
  <div class="mb-6 flex items-center justify-between">
      <div>
          <h1 class="text-xl font-semibold text-gray-900">Arrears Report</h1>
          <p class="text-sm text-gray-500 mt-1">Tenants with outstanding balances</p>
      </div>
      <a href="{{ route('landlord.reports.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
          ← All reports
      </a>
  </div>

  {{-- Filter --}}
  <div class="bg-white rounded-lg border border-gray-100 p-4 mb-6">
      <form method="GET" action="{{ route('landlord.reports.arrears') }}"
            class="grid grid-cols-1 md:grid-cols-3 gap-3 items-end">
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
          <div class="flex gap-2">
              <button type="submit"
                  class="bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium px-4 py-2 rounded transition">
                  Filter
              </button>
              <a href="{{ route('landlord.reports.arrears') }}"
                  class="text-center bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium px-4 py-2 rounded transition">
                  Reset
              </a>
          </div>
      </form>
  </div>

  <div class="flex justify-end mb-4">
    <a href="{{ route('landlord.reports.arrears.export', request()->query()) }}"
       class="bg-white border border-gray-200 hover:border-gray-400 text-gray-700 text-sm font-medium px-4 py-2 rounded-lg transition">
        Export CSV
    </a>
</div>

  {{-- Summary --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
      <x-stat-card label="Tenants with arrears" :value="$report['total_tenants']" />
      <x-stat-card label="Total outstanding" :value="'KES ' . number_format($report['total_arrears'], 2)" color="red" />
  </div>

  {{-- Table --}}
  @if($report['rows']->isEmpty())
      <div class="bg-white rounded-lg border border-gray-100 px-6 py-10 text-center">
          <p class="text-green-600 text-sm font-medium">All tenants are paid up.</p>
      </div>
  @else
      <x-table-wrapper>
          <table class="w-full text-sm text-left">
              <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                  <tr>
                      <th class="px-6 py-3">Tenant</th>
                      <th class="px-6 py-3">Property</th>
                      <th class="px-6 py-3">Unit</th>
                      <th class="px-6 py-3">Since</th>
                      <th class="px-6 py-3">Months</th>
                      <th class="px-6 py-3">Expected</th>
                      <th class="px-6 py-3">Paid</th>
                      <th class="px-6 py-3">Arrears</th>
                  </tr>
              </thead>
              <tbody class="divide-y divide-gray-50">
                  @foreach($report['rows'] as $row)
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
                              {{ \Carbon\Carbon::parse($row['tenancy']->start_date)->format('d M Y') }}
                          </td>
                          <td class="px-6 py-4 text-gray-600">
                              {{ $row['balance']['months_elapsed'] }}
                          </td>
                          <td class="px-6 py-4 text-gray-600">
                              KES {{ number_format($row['balance']['expected_total'], 2) }}
                          </td>
                          <td class="px-6 py-4 text-green-600">
                              KES {{ number_format($row['balance']['paid_total'], 2) }}
                          </td>
                          <td class="px-6 py-4 font-semibold text-red-600">
                              KES {{ number_format($row['balance']['arrears'], 2) }}
                          </td>
                      </tr>
                  @endforeach
              </tbody>
          </table>
      </x-table-wrapper>
  @endif

</x-landlord>