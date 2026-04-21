<x-landlord>
    <h1 class="text-2xl font-bold mb-4">Units for <strong class="text-purple-500">{{ $property->name }}</strong></h1>
    <a href="{{ route('landlord.properties.units.create', $property) }}"class="bg-blue-600 text-white px-4 py-2 rounded">
        + Add Unit
    </a>
    @if (session('success'))
        <div class="mt-4 p-3 bg-green-200 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-6 bg-white shadow rounded">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Unit</th>
                    <th class="p-3 text-left">Rent</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($units as $unit)
                    <tr class="border-t">
                        <td class="p-3">{{ $unit->unit_number }}</td>
                        <td class="p-3">{{ $unit->rent_amount }}</td>
                        <td class="p-3">{{ ucfirst($unit->status) }}</td>
                        <td class="p-3 space-x-2">

                            <a href="{{ route('landlord.properties.units.edit', [$property, $unit]) }}"
                                class="text-blue-600">
                                Edit
                            </a>

                            <form method="POST"
                                action="{{ route('landlord.properties.units.destroy', [$property, $unit]) }}"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this unit?')"
                                    class="text-red-600">
                                    Delete
                                </button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-3 text-gray-500">
                            No units yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


</x-landlord>
