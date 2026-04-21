<x-landlord>
  <div class="mb-6">
      <h1 class="text-xl font-semibold text-gray-900">Reports</h1>
      <p class="text-sm text-gray-500 mt-1">Detailed financial analysis for your portfolio</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

      <a href="{{ route('landlord.reports.payments') }}"
         class="bg-white rounded-lg border border-gray-100 p-6 hover:border-gray-300 transition group">
          <p class="font-semibold text-gray-900 mb-2 group-hover:text-blue-600 transition">
              Payment Report
          </p>
          <p class="text-sm text-gray-500">
              Full transaction history filtered by date, property, and status.
          </p>
      </a>

      <a href="{{ route('landlord.reports.arrears') }}"
         class="bg-white rounded-lg border border-gray-100 p-6 hover:border-gray-300 transition group">
          <p class="font-semibold text-gray-900 mb-2 group-hover:text-blue-600 transition">
              Arrears Report
          </p>
          <p class="text-sm text-gray-500">
              Tenants with outstanding balances and amounts owed.
          </p>
      </a>

      <a href="{{ route('landlord.reports.performance') }}"
         class="bg-white rounded-lg border border-gray-100 p-6 hover:border-gray-300 transition group">
          <p class="font-semibold text-gray-900 mb-2 group-hover:text-blue-600 transition">
              Property Performance
          </p>
          <p class="text-sm text-gray-500">
              Rent collected, arrears, and occupancy per property.
          </p>
      </a>

  </div>
</x-landlord>