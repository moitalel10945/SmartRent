<x-landlord>
  <h1 class="text-xl font-bold mb-4">
    Assign Tenant to Unit 
    </h1>
    
    <form method="POST" action="{{ route('landlord.tenancies.store') }}">
    @csrf
    <div>
    <label>Tenant</label>
    <select name="tenant_id" class="border p-2 w-full">
    @foreach($tenants as $tenant)
    <option value="{{ $tenant->id }}">
    {{ $tenant->name }}
    </option>
    @endforeach
    </select>
  </div>
  <br>

    <div>
      <label>Unit</label>

        <select name="unit_id">

            @foreach($units as $u)

            <option value="{{ $u->id }}">
                {{ $u->property->name }} -
                Unit {{ $u->unit_number }}
            </option>

            @endforeach

        </select>
    </div>
    <br>

    <div>

      <label>Start Date</label>

      <input type="date" name="start_date">

  </div>

  <br>

  <div>

    <label>End Date</label>
    
    <input type="date" name="end_date">
    
    </div>

    <button type="submit"  class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 m-4">
        Assign Tenant
    </button>
    </form>
    
</x-landlord>