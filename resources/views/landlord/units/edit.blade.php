<x-landlord>
  <h1 class="text-2xl font-bold mb-4"> Edit Unit {{ $unit->unit_number }}</h1>
  <form method="POST" action="{{ route('landlord.properties.units.update', [$property, $unit]) }}"class="bg-white p-6 shadow rounded space-y-4">
    @csrf
    @method('PUT')
    <div>
      <label class="block mb-1">Unit Number</label>
      <input type="text" name="unit_number"value="{{ old('unit_number',$unit->unit_numbe) }}" class="w-full border p-2 rounded">

      @error('unit_number')
      <div class="text-red-600 text-sm">{{ $message }}
      </div>
       @enderror

    </div>

    <div>
      <label class="block mb-1">Rent amount</label>
      <input type="number" step="0.01" name="rent_amount"value="{{ old('rent_amount',$unit->rent_amount) }}" class="w-full border p-2 rounded">

      @error('rent_amount')
      <div class="text-red-600 text-sm">{{ $message }}
      </div>
       @enderror
       
    </div>

    <div>
      <label class="block mb-1">Status</label>
      <select name="status" class="w-full border p-2 rounded">
        <option value="vacant" {{ $unit->status === 'vacant' ? 'selected' : '' }}>Vacant</option>
        <option value="occupied" {{ $unit->status === 'occupied' ? 'selected' : '' }}>Occupied</option>
      </select>

      @error('status')
      <div class="text-red-600 text-sm">{{ $message }}
      </div>
       @enderror
       
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
        Update Unit
    </button>
  </form>
</x-landlord>