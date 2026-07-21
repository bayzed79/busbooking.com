@extends('layout')

@section('title', 'Change Password - JatraPoth')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <div class="glass-card">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 fw-bold text-dark mb-0">Change Password</h1>
                <a href="{{ route('view_profile') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>

            <form action="{{ route('update_password') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-lock text-muted"></i></span>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password (Min 8 chars)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-key text-muted"></i></span>
                        <input type="password" class="form-control" id="new_password" name="new_password" minlength="8" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-check-circle text-muted"></i></span>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" minlength="8" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary-touch w-100 py-3 fw-bold">
                    <i class="fas fa-shield-alt me-2"></i> Update Password
                </button>
            </form>
        </div>
    </div>
</div>
@endsection