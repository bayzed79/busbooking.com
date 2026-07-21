@extends('layout')

@section('title', 'My Profile - JatraPoth')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">
        <div class="glass-card">
            <div class="text-center mb-4">
                <div class="display-4 text-primary mb-2">
                    <i class="fas fa-user-circle"></i>
                </div>
                <h1 class="h3 fw-bold text-dark mb-1">{{ Auth::user()->name }}</h1>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill">
                    Passenger Account
                </span>
            </div>

            <div class="bg-light p-3 rounded-3 mb-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="fs-4 text-muted me-3" style="width: 32px;"><i class="fas fa-user"></i></div>
                    <div>
                        <div class="small text-muted">Full Name</div>
                        <div class="fw-semibold text-dark">{{ Auth::user()->name }}</div>
                    </div>
                </div>
                <hr class="my-2 text-muted">
                <div class="d-flex align-items-center mb-3">
                    <div class="fs-4 text-muted me-3" style="width: 32px;"><i class="fas fa-envelope"></i></div>
                    <div>
                        <div class="small text-muted">Email Address</div>
                        <div class="fw-semibold text-dark">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <hr class="my-2 text-muted">
                <div class="d-flex align-items-center">
                    <div class="fs-4 text-muted me-3" style="width: 32px;"><i class="fas fa-phone"></i></div>
                    <div>
                        <div class="small text-muted">Mobile Number</div>
                        <div class="fw-semibold text-dark">{{ Auth::user()->mobile_no ?? 'Not Provided' }}</div>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <a href="{{ route('edit_profile') }}" class="btn btn-primary-touch py-3">
                    <i class="fas fa-user-edit me-2"></i> Edit Profile Details
                </a>
                <a href="{{ route('change_password') }}" class="btn btn-outline-touch py-3">
                    <i class="fas fa-key me-2"></i> Change Password
                </a>
                <a href="{{ route('purchase_history') }}" class="btn btn-outline-secondary py-3">
                    <i class="fas fa-history me-2"></i> My Ticket Purchase History
                </a>
            </div>
        </div>
    </div>
</div>
@endsection