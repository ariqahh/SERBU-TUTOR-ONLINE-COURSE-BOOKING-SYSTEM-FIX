@extends('layouts.auth')

@section('title', 'Verify Email')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ url('/') }}"><b>{{ config('app.name', 'Laravel') }}</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ __('Verify Your Email Address') }}</p>

            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            <p class="text-center mb-3">
                {{ __('Before proceeding, please check your email for a verification link.') }}
            </p>
            
            <p class="text-center mb-3">
                {{ __('If you did not receive the email') }}
            </p>

            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Request another verification email') }}
                    </button>
                </div>
            </form>

            <p class="mt-3 mb-0">
                <a href="{{ route('login') }}" class="text-center">
                    {{ __('Back to login') }}
                </a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
@endsection
