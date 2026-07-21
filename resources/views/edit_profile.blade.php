@extends('layout')

@section('title', 'Edit Profile - JatraPoth')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <div class="glass-card">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 fw-bold text-dark mb-0">Edit Profile</h1>
                <a href="{{ route('view_profile') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back
                </a>
            </div>

            <form action="{{ route('update_profile') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-user text-muted"></i></span>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ Auth::user()->name }}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-envelope text-muted"></i></span>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ Auth::user()->email }}" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary-touch w-100 py-3 fw-bold">
                    <i class="fas fa-save me-2"></i> Save Profile Changes
                </button>
            </form>
        </div>
    </div>
</div>
@endsection