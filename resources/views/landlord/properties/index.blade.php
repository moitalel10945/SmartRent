<x-landlord>
  <h1 class="text-2xl font-bold m-6">Landlord Properties</h1>
  <a href="{{ route('landlord.properties.create')}}" class="bg-blue-600 text-white px-4 py-2 rounded m-4">+ Add Property</a>
  @if(session('success'))
  <div class="mt-4 p-3 bg-green-200 text-green-800 rounded">{{ session('success') }}</div>
  @endif
  <div class="mt-6 bg-white shadow rounded">
    <table class="w-full">
      <thead class="bg-gray-100">
          <tr>
             <th class="p-3 text-left">#</th>
              <th class="p-3 text-left">Name</th>
              <th class="p-3 text-left">Location</th>
              <th class="p-3 text-left">Actions</th>
          </tr>
      </thead>
      <tbody>
        @forelse($properties as $property)
            <tr class="border-t">
                <td class="p-3">
                    <a href="{{ route('landlord.properties.show',$property) }}" class="bg-green-500 p-2 text-white text-xs rounded-xl">View</a></td>
                <td class="p-3">{{ $property->name }}</td>
                <td class="p-3">{{ $property->location }}</td>
                <td class="p-3 space-x-2">

                    <a href="{{ route('landlord.properties.edit', $property) }}"
                       class="text-blue-600">Edit</a>

                    <form action="{{ route('landlord.properties.destroy', $property) }}"
                          method="POST"
                          class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Delete this property?')"
                                class="text-red-600">
                            Delete
                        </button>
                    </form>

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="p-3 text-gray-500">
                    No properties yet.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
  </div>
</x-landlord>