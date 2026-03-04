
  <x-landlord>
    <h1 class="text-2xl font-bold mb-4">Edit Property</h1>
    <form action="{{ route('landlord.properties.update',$property) }}" method="POST" class="bg-white p-6 shadow rounded space-y-4">
      @csrf
      @method('PUT')
      {{--  <input type="hidden" name="_method" value="PUT">--}}
      <div>
        <label class="block mb-1">Name</label>
        <input type="text" name="name"
               value="{{$property->name }}"
               class="w-full border p-2 rounded">
        @error('name')
            <div class="text-red-600 text-sm">{{ $message }}</div>
        @enderror
    </div>
    <div>
      <label class="block mb-1">Location</label>
      <input type="text" name="location"
             value="{{ $property->location }}"
             class="w-full border p-2 rounded">
      @error('location')
          <div class="text-red-600 text-sm">{{ $message }}</div>
      @enderror
  </div>
  <div>
    <label class="block mb-1">Description (optional)</label>
    <textarea name="description"
              class="w-full border p-2 rounded">{{ $property->description }}</textarea>
  </div>
  <button type="submit"
              class="bg-blue-600 text-white px-4 py-2 rounded">
          Update Property
      </button>
    </form>
  </x-landlord>