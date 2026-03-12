@extends('admin.layouts.app')

@section('title', 'Settings')
@section('page-title', 'Account Settings')

@section('content')
    <div style="max-width: 600px;">
        <div class="card">
            <h4 style="color: var(--gold-primary); margin-bottom: 1.5rem;">
                <i class="fas fa-key"></i> Change Password
            </h4>

            @if($errors->any())
                <div class="alert alert-error" style="margin-bottom: 1.5rem;">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.settings.password') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" required
                        placeholder="Enter current password">
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="password" name="password" required
                        placeholder="Enter new password (min 8 characters)">
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                        required placeholder="Confirm new password">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.9rem; font-weight: 600;">
                    <i class="fas fa-save"></i> Update Password
                </button>
            </form>
        </div>

        <div class="card">
            <h4 style="color: var(--gold-primary); margin-bottom: 1rem;">
                <i class="fas fa-user"></i> Account Info
            </h4>
            <div style="color: var(--text-secondary); font-size: 0.9rem;">
                <p style="margin-bottom: 0.5rem;">
                    <strong>Name:</strong> {{ Auth::guard('admin')->user()->name }}
                </p>
                <p>
                    <strong>Username:</strong> {{ Auth::guard('admin')->user()->username }}
                </p>
            </div>
        </div>
    </div>
@endsection
