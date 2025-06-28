@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="register-box">
    <div class="login-logo">
        <a href="{{ url('/') }}"><b>{{ config('app.name', 'Laravel') }}</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Daftar</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           placeholder="Nama" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    <div class="input-group-text">
                        <span class="bi bi-person"></span>
                    </div>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           placeholder="Email" value="{{ old('email') }}" required autocomplete="email">
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
                           placeholder="Kata Sandi" required autocomplete="new-password">
                    <div class="input-group-text">
                        <span class="bi bi-lock-fill"></span>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation" class="form-control"
                           placeholder="Konfirmasi Kata Sandi" required autocomplete="new-password">
                    <div class="input-group-text">
                        <span class="bi bi-lock-fill"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-8">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" required>
                            <label class="form-check-label">
                                setuju
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Daftar') }}
                            </button>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <p class="mt-3 mb-0">
                <a href="{{ route('login') }}" class="text-center">
                    {{ __('saya sudah memiliki akun') }}
                </a>
            </p>
        </div>
        <!-- /.register-card-body -->
    </div>
</div>
@endsection
