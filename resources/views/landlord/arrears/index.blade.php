<x-landlord>
  <h1 class="text-2xl font-bold mb-6">Rent Arrears</h1>

  {{-- Summary cards --}}
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
      <div class="bg-white shadow rounded-lg p-6">
          <p class="text-sm text-gray-500 mb-1">Total Collected</p>
          <p class="text-2xl font-bold text-green-600">
              KES {{ number_format($totalPaid, 2) }}
          </p>
      </div>
      <div class="bg-white shadow rounded-lg p-6">
          <p class="text-sm text-gray-500 mb-1">Total Outstanding</p>
          <p class="text-2xl font-bold text-red-600">
              KES {{ number_format($totalArrears, 2) }}
          </p>
      </div>
  </div>

  {{-- Arrears table --}}
  <div class="bg-white shadow rounded-lg overflow-hidden">
      <table class="w-full text-sm text-left">
          <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
              <tr>
                  <th class="px-6 py-3">Tenant</th>
                  <th class="px-6 py-3">Property</th>
                  <th class="px-6 py-3">Unit</th>
                  <th class="px-6 py-3">Expected</th>
                  <th class="px-6 py-3">Paid</th>
                  <th class="px-6 py-3">Arrears</th>
                  <th class="px-6 py-3">Status</th>
              </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
              @foreach($summary as $row)
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
                          KES {{ number_format($row['balance']['expected_total'], 2) }}
                      </td>
                      <td class="px-6 py-4 text-green-600 font-medium">
                          KES {{ number_format($row['balance']['paid_total'], 2) }}
                      </td>
                      <td class="px-6 py-4 font-medium
                          {{ $row['balance']['is_owing'] ? 'text-red-600' : 'text-green-600' }}">
                          KES {{ number_format($row['balance']['arrears'], 2) }}
                      </td>
                      <td class="px-6 py-4">
                          @if($row['balance']['is_paid_up'])
                              <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-medium">
                                  Paid up
                              </span>
                          @else
                              <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-medium">
                                  Owing
                              </span>
                          @endif
                      </td>
                  </tr>
              @endforeach
          </tbody>
      </table>
  </div>
</x-landlord>