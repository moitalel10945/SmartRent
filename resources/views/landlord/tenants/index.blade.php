<x-landlord>
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem">
      <div>
          <h1 class="page-title">Tenants</h1>
          <p class="page-subtitle">All tenant accounts you have created</p>
      </div>
      <a href="{{ route('landlord.tenants.create') }}" class="btn btn-primary">
          Add Tenant
      </a>
  </div>

  <x-flash />

  @if($tenants->isEmpty())
      <div class="empty-state">
          <p>No tenants yet.</p>
          <small>Create a tenant account before assigning a tenancy.</small>
          <a href="{{ route('landlord.tenants.create') }}"
             style="margin-top:1rem;font-size:0.8125rem;color:var(--text-primary);font-weight:500">
              Create your first tenant →
          </a>
      </div>
  @else
      <x-table-wrapper>
          <table class="sr-table">
              <thead>
                  <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Tenancies</th>
                      <th>Registered</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($tenants as $tenant)
                      <tr>
                          <td data-label="Name" style="font-weight:500">
                              {{ $tenant->name }}
                          </td>
                          <td data-label="Email" class="muted">
                              {{ $tenant->email }}
                          </td>
                          <td data-label="Phone" class="muted">
                              {{ $tenant->phone }}
                          </td>
                          <td data-label="Tenancies">
                              <span class="badge {{ $tenant->tenancies_count > 0 ? 'badge-green' : 'badge-gray' }}">
                                  {{ $tenant->tenancies_count }}
                                  {{ Str::plural('tenancy', $tenant->tenancies_count) }}
                              </span>
                          </td>
                          <td data-label="Registered" class="muted">
                              {{ $tenant->created_at->format('d M Y') }}
                          </td>
                      </tr>
                  @endforeach
              </tbody>
          </table>
      </x-table-wrapper>
  @endif
</x-landlord>