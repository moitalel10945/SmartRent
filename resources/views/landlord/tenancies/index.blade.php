<x-landlord>
  <div class="max-w-6xl mx-auto p-6"></div>
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Tenancies</h1>
<a href="{{ route('landlord.tenancies.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Assign Tenant</a>
</div>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif
<div class="bg-white shadow rounded overflow-hidden">
<table class="min-w-full">
    <thead class="min-w-full">
        <tr>
            <th class="p-3">Tenant</th>
            <th class="p-3">Property</th>
            <th class="p-3">Unit</th>
            <th class="p-3">Rent</th>
            <th class="p-3">Start Date</th>
            <th class="p-3">Status</th>
            <th class="p-3">Action</th>
        </tr>
    </thead>

    <tbody>

        @foreach($tenancies as $tenancy)

        <tr class="border-t">
            <td class="p-3">{{ $tenancy->tenant->name }}</td>

            <td class="p-3">
                {{ $tenancy->unit->property->name }}
            </td>

            <td class="p-3">
                {{ $tenancy->unit->unit_number }}
            </td>

            <td class="p-3">
                {{ $tenancy->rent_amount_snapshot }}
            </td>

            <td class="p-3">
                {{ $tenancy->start_date }}
            </td>

            <td class="p-3">
                @if($tenancy->active)
                    Active
                @else
                    Ended
                @endif
            </td>

            <td class="p-3">

                @if($tenancy->active)

                <form method="POST"
                    action="{{ route('landlord.tenancies.destroy', $tenancy) }}">

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="bg-red-500 text-white p-2 rounded-lg">
                        End Tenancy
                    </button>

                </form>

                @endif

            </td>

        </tr>

        @endforeach

    </tbody>
</table>
</div>
</div>
</x-landlord>