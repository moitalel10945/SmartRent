<x-landlord>
  <h2 class="text-xl font-bold">
    {{ $property->name }}
</h2>

<p class="mb-5 font-bold">{{ $property->location }}</p>

<a href="{{ route('landlord.properties.units.index', $property) }}" class="bg-blue-500 text-white p-2">
  Manage Units
</a>
</x-landlord>