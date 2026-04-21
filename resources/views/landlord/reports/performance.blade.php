<x-landlord>
  <div class="mb-6 flex items-center justify-between">
      <div>
          <h1 class="text-xl font-semibold text-gray-900">Property Performance</h1>
          <p class="text-sm text-gray-500 mt-1">Financial overview per property</p>
      </div>
      <a href="{{ route('landlord.reports.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
          ← All reports
      </a>
  </div>

  {{-- Filters --}}
  <div class="bg-white rounded-lg border border-gray-100 p-4 mb-6">
      <form method="GET" action="{{ route('landlord.reports.performance') }}"
            class="grid grid-cols-1 md:grid-cols-4 gap-3 items-end">
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
              <a href="{{ route('landlord.reports.performance') }}"
                  class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-medium px-4 py-2 rounded transition">
                  Reset
              </a>
          </div>
      </form>
  </div>

  <div class="flex justify-end mb-4">
    <a href="{{ route('landlord.reports.performance.export', request()->query()) }}"
       class="bg-white border border-gray-200 hover:border-gray-400 text-gray-700 text-sm font-medium px-4 py-2 rounded-lg transition">
        Export CSV
    </a>
</div>

  {{-- Portfolio summary --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
      <x-stat-card label="Total properties" :value="$report['rows']->count()" />
      <x-stat-card label="Total units" :value="$report['total_units']" />
      <x-stat-card label="Total collected" :value="'KES ' . number_format($report['total_collected'], 2)" color="green" />
      <x-stat-card label="Total arrears" :value="'KES ' . number_format($report['total_arrears'], 2)" :color="$report['total_arrears'] > 0 ? 'red' : 'green'" />
  </div>

  {{-- Table --}}
  @if($report['rows']->isEmpty())
      <div class="bg-white rounded-lg border border-gray-100 px-6 py-10 text-center">
          <p class="text-gray-400 text-sm">No properties found.</p>
      </div>
  @else
      <x-table-wrapper>
          <table class="w-full text-sm text-left">
              <thead class="bg-gray-50 text-xs text-gray-500 uppercase tracking-wide">
                  <tr>
                      <th class="px-6 py-3">Property</th>
                      <th class="px-6 py-3">Units</th>
                      <th class="px-6 py-3">Occupied</th>
                      <th class="px-6 py-3">Vacant</th>
                      <th class="px-6 py-3">Occupancy</th>
                      <th class="px-6 py-3">Collected</th>
                      <th class="px-6 py-3">Arrears</th>
                  </tr>
              </thead>
              <tbody class="divide-y divide-gray-50">
                  @foreach($report['rows'] as $row)
                      <tr class="hover:bg-gray-50">
                          <td class="px-6 py-4 font-medium text-gray-900">
                              {{ $row['property']->name }}
                          </td>
                          <td class="px-6 py-4 text-gray-600">{{ $row['total_units'] }}</td>
                          <td class="px-6 py-4 text-gray-600">{{ $row['occupied'] }}</td>
                          <td class="px-6 py-4 text-gray-600">{{ $row['vacant'] }}</td>
                          <td class="px-6 py-4">
                              <div class="flex items-center gap-2">
                                  <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                      <div class="h-1.5 rounded-full
                                          {{ $row['occupancy_rate'] >= 75 ? 'bg-green-500' : ($row['occupancy_rate'] >= 50 ? 'bg-yellow-400' : 'bg-red-400') }}"
                                          style="width: {{ $row['occupancy_rate'] }}%">
                                      </div>
                                  </div>
                                  <span class="text-gray-600 text-xs w-8">{{ $row['occupancy_rate'] }}%</span>
                              </div>
                          </td>
                          <td class="px-6 py-4 font-medium text-green-600">
                              KES {{ number_format($row['collected'], 2) }}
                          </td>
                          <td class="px-6 py-4 font-medium {{ $row['arrears'] > 0 ? 'text-red-600' : 'text-gray-400' }}">
                              KES {{ number_format($row['arrears'], 2) }}
                          </td>
                      </tr>
                  @endforeach
              </tbody>
          </table>
      </x-table-wrapper>
  @endif

</x-landlord>