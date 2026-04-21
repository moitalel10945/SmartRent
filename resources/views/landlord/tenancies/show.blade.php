<x-landlord>
 <h1>Tenancy Details</h1>

<p>Tenant: {{ $tenancy->tenant->name }}</p>

<p>Property: {{ $tenancy->unit->property->name }}</p>

<p>Unit: {{ $tenancy->unit->unit_number }}</p>

<p>Rent: {{ $tenancy->rent_amount_snapshot }}</p>

<p>Start Date: {{ $tenancy->start_date }}</p>

<p>Status:
@if($tenancy->active)
Active
@else
Ended
@endif
</p>

</x-landlord>