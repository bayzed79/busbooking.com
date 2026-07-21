@extends('mainlayout')
@section('content')
    <div>
        <h2>Forgot Password</h2>

        <!-- Display status or errors if any -->
        @if (session('status'))
            <div>
                {{ session('status') }}
            </div>
        @endif

        <!-- Display validation errors if any -->
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Forgot password form -->
        <!-- reset-password.blade.php -->
        @if ($errors->has('email'))
            <div class="alert alert-danger">{{ $errors->first('email') }}</div>
        @endif

        <form method="POST" action="{{ route('resetPasswordPost') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <label for="email">Email</label>
            <input id="email" type="email" name="email" required>

            <label for="password">New Password</label>
            <input id="password" type="password" name="password" required>

            <label for="password_confirmation">Confirm New Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>

            <button type="submit">Reset Password</button>
        </form>

    </div>
@endsection
