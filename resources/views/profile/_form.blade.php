<div style="max-width:600px">

  <div style="margin-bottom:1.5rem">
      <h1 class="page-title">My Profile</h1>
      <p class="page-subtitle">Manage your account information</p>
  </div>

  <x-flash />

  {{-- Profile details card --}}
  <div class="card" style="margin-bottom:1.25rem">
      <p class="card-title" style="margin-bottom:1.25rem">Personal Information</p>

      <form method="POST" action="{{ route('profile.update') }}">
          @csrf
          @method('PATCH')

          <div class="form-group">
              <label class="form-label">Full Name</label>
              <input type="text"
                  name="name"
                  value="{{ old('name', $user->name) }}"
                  class="form-input"
                  required>
              @error('name')
                  <p class="form-error">{{ $message }}</p>
              @enderror
          </div>

          <div class="form-group">
              <label class="form-label">Email Address</label>
              <input type="email"
                  name="email"
                  value="{{ old('email', $user->email) }}"
                  class="form-input"
                  required>
              @error('email')
                  <p class="form-error">{{ $message }}</p>
              @enderror

              @if($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                  <p style="font-size:0.75rem;color:var(--warning);margin-top:0.375rem">
                      Your email is unverified.
                      <button form="send-verification" style="background:none;border:none;color:var(--warning);cursor:pointer;text-decoration:underline;font-size:0.75rem">
                          Resend verification email
                      </button>
                  </p>

                  @if(session('status') === 'verification-link-sent')
                      <p style="font-size:0.75rem;color:var(--success);margin-top:0.25rem">
                          A new verification link has been sent to your email.
                      </p>
                  @endif
              @endif
          </div>

          <div class="form-group">
              <label class="form-label">Phone Number</label>
              <input type="tel"
                  name="phone"
                  value="{{ old('phone', $user->phone) }}"
                  class="form-input"
                  placeholder="07XXXXXXXX"
                  required>
              @error('phone')
                  <p class="form-error">{{ $message }}</p>
              @enderror
          </div>

          <div style="padding-top:0.75rem;border-top:1px solid var(--border);margin-top:0.25rem">
              <button type="submit" class="btn btn-primary">
                  Save Changes
              </button>
          </div>
      </form>
  </div>

  {{-- Change password card --}}
  <div class="card" style="margin-bottom:1.25rem">
      <p class="card-title" style="margin-bottom:1.25rem">Change Password</p>

      <form method="POST" action="{{ route('password.update') }}">
          @csrf
          @method('PUT')

          <div class="form-group">
              <label class="form-label">Current Password</label>
              <input type="password"
                  name="current_password"
                  class="form-input"
                  autocomplete="current-password">
              @error('current_password', 'updatePassword')
                  <p class="form-error">{{ $message }}</p>
              @enderror
          </div>

          <div class="form-group">
              <label class="form-label">New Password</label>
              <input type="password"
                  name="password"
                  class="form-input"
                  autocomplete="new-password">
              @error('password', 'updatePassword')
                  <p class="form-error">{{ $message }}</p>
              @enderror
          </div>

          <div class="form-group">
              <label class="form-label">Confirm New Password</label>
              <input type="password"
                  name="password_confirmation"
                  class="form-input"
                  autocomplete="new-password">
          </div>

          <div style="padding-top:0.75rem;border-top:1px solid var(--border);margin-top:0.25rem">
              <button type="submit" class="btn btn-primary">
                  Update Password
              </button>
          </div>
      </form>
  </div>

  {{-- Delete account card --}}
  <div class="card" style="border-color:color-mix(in srgb, var(--danger) 20%, var(--border))">
      <p class="card-title" style="margin-bottom:0.375rem;color:var(--danger)">Delete Account</p>
      <p style="font-size:0.8125rem;color:var(--text-muted);margin-bottom:1.25rem">
          Once deleted, all data will be permanently removed. This cannot be undone.
      </p>

      <form method="POST" action="{{ route('profile.destroy') }}"
            onsubmit="return confirm('Are you sure? This will permanently delete your account.')">
          @csrf
          @method('DELETE')

          <div class="form-group">
              <label class="form-label">Enter your password to confirm</label>
              <input type="password"
                  name="password"
                  class="form-input"
                  placeholder="Your current password">
              @error('password', 'userDeletion')
                  <p class="form-error">{{ $message }}</p>
              @enderror
          </div>

          <button type="submit" class="btn btn-danger">
              Delete My Account
          </button>
      </form>
  </div>

</div>

{{-- Hidden form for email verification resend --}}
<form id="send-verification" method="POST" action="{{ route('verification.send') }}" style="display:none">
  @csrf
</form>