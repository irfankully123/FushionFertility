@extends('layouts.guest')
@section('title')
    {{ _('Email Verification') }}
@endsection
@section('email-verification')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Forgot Password -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <img src="web/assets/img/logo.png" alt="web-logo" class="img-fluid" >
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2 text-center">Email Verification</h4>
                        <p class="mb-4 text-center">A new verification link has been sent to the email address you provided during
                            registration.</p>
                        <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
                            @csrf

                            <div class="text-center">
                                <button class="btn btn-primary w-100" type="submit">Resend Verification Link</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- /Forgot Password -->

