<x-tenant>
  <div class="max-w-lg mx-auto">
      <h1 class="text-2xl font-bold mb-6">Payment Receipt</h1>

      <div class="bg-white shadow rounded-lg p-8">

          <div class="text-center mb-6">
              <p class="text-gray-500 text-sm">Receipt Number</p>
              <p class="text-2xl font-bold text-gray-900 tracking-wide">
                  {{ $receipt->receipt_number }}
              </p>
          </div>

          <div class="border-t border-gray-100 pt-6 space-y-4">
              <div class="flex justify-between">
                  <span class="text-gray-500">Amount Paid</span>
                  <span class="font-semibold text-gray-900">KES {{ number_format($receipt->amount, 2) }}</span>
              </div>
              <div class="flex justify-between">
                  <span class="text-gray-500">M-Pesa Reference</span>
                  <span class="font-semibold text-gray-900">{{ $receipt->mpesa_receipt }}</span>
              </div>
              <div class="flex justify-between">
                  <span class="text-gray-500">Phone</span>
                  <span class="font-semibold text-gray-900">{{ $receipt->phone }}</span>
              </div>
              <div class="flex justify-between">
                  <span class="text-gray-500">Date</span>
                  <span class="font-semibold text-gray-900">
                      {{ $receipt->generated_at->format('d M Y, h:i A') }}
                  </span>
              </div>
              <div class="flex justify-between">
                  <span class="text-gray-500">Property</span>
                  <span class="font-semibold text-gray-900">
                      {{ $receipt->payment->tenancy->unit->property->name }}
                  </span>
              </div>
              <div class="flex justify-between">
                  <span class="text-gray-500">Unit</span>
                  <span class="font-semibold text-gray-900">
                      {{ $receipt->payment->tenancy->unit->unit_number }}
                  </span>
              </div>
          </div>

          <div class="mt-8 text-center">
              <span class="inline-block px-4 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">
                  Payment Confirmed
              </span>
          </div>

      </div>

      <div class="mt-4 text-center">
          <a href="{{ route('tenant.payments.index') }}"
             class="text-sm text-gray-500 hover:text-gray-700">
              Back to payment history
          </a>
      </div>
  </div>
</x-tenant>