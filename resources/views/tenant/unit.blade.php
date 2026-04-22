<x-tenant>
  @if($tenancy)
      {{-- Hero background --}}
      <div style="
          position: relative;
          border-radius: 1rem;
          overflow: hidden;
          margin-bottom: 1.5rem;
          min-height: 220px;
          display: flex;
          align-items: flex-end;
          background-image: url('https://images.unsplash.com/photo-1545324418-cc1a3fa10c00?w=1200&auto=format&fit=crop&q=80');
          background-size: cover;
          background-position: center;
      ">
          {{-- Overlay --}}
          <div style="
              position: absolute;
              inset: 0;
              background: linear-gradient(to top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.1) 60%);
          "></div>

          {{-- Content on top of image --}}
          <div style="position: relative; padding: 1.75rem 2rem; width: 100%">
              <p style="font-size:0.75rem;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.6);margin-bottom:0.25rem">
                  {{ $tenancy->unit->property->name }}
              </p>
              <h1 style="font-family:var(--font-display);font-size:2rem;color:#ffffff;letter-spacing:-0.02em;line-height:1">
                  Unit {{ $tenancy->unit->unit_number }}
              </h1>
              <p style="font-size:0.8125rem;color:rgba(255,255,255,0.6);margin-top:0.375rem">
                  {{ $tenancy->unit->property->location }}
              </p>
          </div>
      </div>

      {{-- Details grid --}}
      <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem;margin-bottom:1.5rem">

          <div class="card">
              <p class="stat-label">Monthly Rent</p>
              <p class="stat-value">KES {{ number_format($tenancy->unit->rent_amount, 2) }}</p>
          </div>

          <div class="card">
              <p class="stat-label">Unit Status</p>
              <div style="margin-top:0.5rem">
                  <x-status-badge :status="$tenancy->unit->status" />
              </div>
          </div>

          <div class="card">
              <p class="stat-label">Tenancy Start</p>
              <p class="stat-value" style="font-size:1.1rem">
                  {{ \Carbon\Carbon::parse($tenancy->start_date)->format('d M Y') }}
              </p>
          </div>

          <div class="card">
              <p class="stat-label">Tenancy End</p>
              <p class="stat-value" style="font-size:1.1rem">
                  {{ \Carbon\Carbon::parse($tenancy->end_date)->format('d M Y') }}
              </p>
          </div>

      </div>

      {{-- Property details card --}}
      <div class="card">
          <p class="card-title" style="margin-bottom:1.25rem">Property Details</p>
          <dl style="display:flex;flex-direction:column;gap:0.875rem">
              <div style="display:flex;justify-content:space-between;align-items:center;padding-bottom:0.875rem;border-bottom:1px solid var(--border)">
                  <dt style="font-size:0.8125rem;color:var(--text-muted)">Property Name</dt>
                  <dd style="font-size:0.8125rem;font-weight:600;color:var(--text-primary)">
                      {{ $tenancy->unit->property->name }}
                  </dd>
              </div>
              <div style="display:flex;justify-content:space-between;align-items:center;padding-bottom:0.875rem;border-bottom:1px solid var(--border)">
                  <dt style="font-size:0.8125rem;color:var(--text-muted)">Location</dt>
                  <dd style="font-size:0.8125rem;font-weight:600;color:var(--text-primary)">
                      {{ $tenancy->unit->property->location }}
                  </dd>
              </div>
              <div style="display:flex;justify-content:space-between;align-items:center;padding-bottom:0.875rem;border-bottom:1px solid var(--border)">
                  <dt style="font-size:0.8125rem;color:var(--text-muted)">Unit Number</dt>
                  <dd style="font-size:0.8125rem;font-weight:600;color:var(--text-primary)">
                      {{ $tenancy->unit->unit_number }}
                  </dd>
              </div>
              <div style="display:flex;justify-content:space-between;align-items:center">
                  <dt style="font-size:0.8125rem;color:var(--text-muted)">Description</dt>
                  <dd style="font-size:0.8125rem;font-weight:500;color:var(--text-secondary);text-align:right;max-width:60%">
                      {{ $tenancy->unit->property->description ?? 'No description provided.' }}
                  </dd>
              </div>
          </dl>
      </div>

  @else
      <div class="empty-state">
          <p>You are not currently assigned to a unit.</p>
          <small>Please contact your landlord to get assigned.</small>
      </div>
  @endif
</x-tenant>