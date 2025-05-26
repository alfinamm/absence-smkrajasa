@extends('layouts.master-without-nav')
@section('title')
  @lang('translation.Login')
@endsection
@section('content')
  <div class="account-pages my-5 pt-sm-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="text-center">
            <a href="{{ url('index') }}" class="mb-5 d-block auth-logo">
              <img src="{{ URL::asset('/assets/images/logo-dark.png') }}" alt="" width="200"
                class="logo logo-dark">
              <img src="{{ URL::asset('/assets/images/logo-light.png') }}" alt=""  width="200"
                class="logo logo-light">
            </a>
          </div>
        </div>
      </div>
      <div class="row align-items-center justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
          <div class="card">

            <div class="card-body p-4">
              <div class="text-center mt-2">
                <h5 class="text-primary">Welcome Back !</h5>
                <p class="text-muted">Sign in to continue to SMK Rajasa.</p>
              </div>
              <div class="p-2 mt-4">
                <form method="POST" action="{{ route('login') }}">
                  @csrf

                  <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"
                      value="{{ old('email', 'admin@absence.com') }}" id="email" placeholder="Enter Email address">
                    @error('email')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>

                  <div class="mb-3">
                    <div class="float-end">
                      @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-muted">Forgot
                          password?</a>
                      @endif
                    </div>
                    <label class="form-label" for="userpassword">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" value="12345678"
                      name="password" id="userpassword" placeholder="Enter password">
                    @error('password')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>

                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="auth-remember-check" name="remember"
                      {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="auth-remember-check">Remember me</label>
                  </div>

                  <div class="mt-3 text-end">
                    <button class="btn btn-primary w-sm waves-effect waves-light" type="submit">Log
                      In</button>
                  </div>

                </form>
              </div>

            </div>
          </div>

          <div class="mt-5 text-center">
            <p>©
              <script>
                document.write(new Date().getFullYear())
              </script> <i ">SMK Rajasa.</i>
            </p>
          </div>

        </div>
      </div>
      <!-- end row -->
    </div>
    <!-- end container -->
  </div>
@endsection
