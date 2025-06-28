@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ url('/') }}"><b>{{ config('app.name', 'Laravel') }}</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">masuk</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    <div class="input-group-text">
                        <span class="bi bi-envelope"></span>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                           placeholder="Password" required autocomplete="current-password">
                    <div class="input-group-text">
                        <span class="bi bi-lock-fill"></span>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-8">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember"
                                   id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Ingat Saya') }}
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Masuk') }}
                            </button>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            @if (Route::has('register'))
                <p class="mb-0">
                    <a href="{{ route('register') }}" class="text-center">
                        {{ __('Daftar Akun') }}
                    </a>
                </p>
            @endif
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
@endsection
