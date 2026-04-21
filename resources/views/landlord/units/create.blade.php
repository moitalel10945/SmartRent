<x-landlord>
  <h1 class="text-2xl font-bold mb-4"> Add Unit to{{ $property->name }}</h1>
  <form method="POST" action="{{ route('landlord.properties.units.store', $property) }}"class="bg-white p-6 shadow rounded space-y-4">
    @csrf
    <div>
      <label class="block mb-1">Unit Number</label>
      <input type="text" name="unit_number"value="{{ old('unit_number') }}" class="w-full border p-2 rounded">

      @error('unit_number')
      <div class="text-red-600 text-sm">{{ $message }}
      </div>
       @enderror

    </div>

    <div>
      <label class="block mb-1">Rent amount</label>
      <input type="number" step="0.01" name="rent_amount"value="{{ old('rent_amount') }}" class="w-full border p-2 rounded">

      @error('rent_amount')
      <div class="text-red-600 text-sm">{{ $message }}
      </div>
       @enderror
       
    </div>

    <div>
      <label class="block mb-1">Status</label>
      <select name="status" class="w-full border p-2 rounded">
        <option value="vacant">Vacant</option>
        <option value="occupied">Occupied</option>
      </select>

      @error('status')
      <div class="text-red-600 text-sm">{{ $message }}
      </div>
       @enderror
       
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
        Save Unit
    </button>
  </form>
</x-landlord>