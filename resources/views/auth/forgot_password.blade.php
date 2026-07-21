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
        <form method="POST" action="{{ route('forgot_passwordPost') }}">
            @csrf

            <!-- Email input field -->
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <!-- Submit button -->
            <div>
                <button type="submit">Send Reset Link</button>
            </div>
        </form>
    </div>
@endsection
