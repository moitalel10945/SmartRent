<x-landlord>
  <div style="max-width:520px">
      <div style="margin-bottom:1.5rem">
          <a href="{{ route('landlord.tenants.index') }}"
             style="font-size:0.8125rem;color:var(--text-muted);text-decoration:none">
              ← Back to tenants
          </a>
      </div>

      <h1 class="page-title" style="margin-bottom:0.25rem">Create Tenant Account</h1>
      <p class="page-subtitle" style="margin-bottom:1.5rem">
          The tenant will use these credentials to log in.
      </p>

      <div class="card">
          <form method="POST" action="{{ route('landlord.tenants.store') }}">
              @csrf

              <div class="form-group">
                  <label class="form-label">Full Name</label>
                  <input type="text"
                      name="name"
                      value="{{ old('name') }}"
                      class="form-input"
                      placeholder="Jane Doe"
                      required>
                  @error('name')
                      <p class="form-error">{{ $message }}</p>
                  @enderror
              </div>

              <div class="form-group">
                  <label class="form-label">Email Address</label>
                  <input type="email"
                      name="email"
                      value="{{ old('email') }}"
                      class="form-input"
                      placeholder="jane@example.com"
                      required>
                  @error('email')
                      <p class="form-error">{{ $message }}</p>
                  @enderror
              </div>

              <div class="form-group">
                  <label class="form-label">Phone Number</label>
                  <input type="tel"
                      name="phone"
                      value="{{ old('phone') }}"
                      class="form-input"
                      placeholder="07XXXXXXXX"
                      required>
                  @error('phone')
                      <p class="form-error">{{ $message }}</p>
                  @enderror
              </div>

              <div class="form-group">
                  <label class="form-label">Password</label>
                  <input type="password"
                      name="password"
                      class="form-input"
                      placeholder="Minimum 8 characters"
                      required>
                  @error('password')
                      <p class="form-error">{{ $message }}</p>
                  @enderror
              </div>

              <div class="form-group">
                  <label class="form-label">Confirm Password</label>
                  <input type="password"
                      name="password_confirmation"
                      class="form-input"
                      placeholder="Repeat password"
                      required>
              </div>

              <div style="padding-top:0.5rem;border-top:1px solid var(--border);margin-top:0.5rem;display:flex;gap:0.75rem">
                  <button type="submit" class="btn btn-primary">
                      Create Tenant
                  </button>
                  <a href="{{ route('landlord.tenants.index') }}" class="btn btn-secondary">
                      Cancel
                  </a>
              </div>
          </form>
      </div>
  </div>
</x-landlord>