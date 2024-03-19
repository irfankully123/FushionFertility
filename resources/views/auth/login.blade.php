@extends('layouts.guest')
@section('title'){{ _('Fusion - Login') }}@endsection
@section('login')
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
                 <img src="web/assets/img/logo.png" alt="web-logo" class="img-fluid" >
            </div>


            <form   class="mb-3" action="{{ route('login') }}" method="POST">
              @csrf
              <div class="mb-3">
                <label for="email" class="form-label">Email or Username</label>
                <input
                  type="text"
                  class="form-control"
                  id="email"
                  name="email"
                  placeholder="Enter your email or username"
                  autofocus
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
              </div>
              <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password">Password</label>
                </div>
                <div class="input-group input-group-merge">
                  <input
                    type="password"
                    id="password"
                    class="form-control"
                    name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password"
                  />

                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>

                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
              </div>
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="remember-me" />
                  <label class="form-check-label" for="remember-me"> Remember Me </label>
                </div>
              </div>

              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
              </div>
            </form>
            <p class="text-center">
              <span>New on our platform?</span>
              <a href="{{ route('register') }}">
                <span>Create an account</span>
              </a>
            </p>
              <p class="text-center">
                  <a href="{{ route('google.login') }}" class="btn btn-light btn-outline-primary w-75">
                      <img src="{{ asset('web/google.png') }}" width="20" height="20" class="img-fluid" alt="google-logo"/>
                      <span class="">Google</span>
                  </a>
              </p>
          </div>
        </div>
        <!-- /Register -->
      </div>
    </div>
  </div>
  @endsection




