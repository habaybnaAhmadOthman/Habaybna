{{-- @extends('layouts.app')

@section('content')
@if (\Session::has('msg'))
    <div class="alert alert-danger">
        <ul>
            <li>{!! \Session::get('msg') !!}</li>
        </ul>
    </div>
@endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Check OTP') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('check-otp') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="otp" class="col-md-4 col-form-label text-md-right"> <strong>{{ __('OTP Code') }}</strong> </label>

                            <div class="col-md-6">
                                <input id="otp" type="text" class="form-control" name="otp" required  autofocus>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Check') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Send again?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Home | habaybna</title>
      <!-- js -->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
      <!-- Fonts -->
      <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
      <link rel="dns-prefetch" href="//fonts.gstatic.com">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
      {{--
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">
      --}}
      {{--
      <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
      --}}
      <!-- Styles -->
      <style>

    body {
  background-image: linear-gradient(#9400d3, #ff6347);
  background-repeat: no-repeat;
  background-attachment: fixed;
  height: 100%;
  margin: 0;
  display: flex;
  align-items: center;
  color: white;
  font-family: "Montserrat", sans-serif;
  font-size: 14px;
  justify-content: center;
}

a {
  color: white;
  text-decoration: none;
  font-weight: bold;
  outline: none;
  transition: all 0.2s;
}

a:hover,
a:focus {
  color: #fdc654;
  transition: all 0.2s;
}

html {
  height: 100%;
}

.login-card {
  padding: 32px 32px 0;
  box-sizing: border-box;
  text-align: center;
  width: 100%;
  /* display: none; */
  height: 100%;
  max-height: 740px;
  max-width: 350px;
  flex-direction: column;
}

.login-card-content {
  flex-grow: 2;
  justify-content: center;
  display: flex;
  flex-direction: column;
}

.login-card-footer {
  padding: 32px 0;
}

h2 .highlight {
  color: #3f0e54;
}

h2 {
  font-size: 32px;
  margin: 0;
}

h3 {
  color: #d61e2d;
  font-size: 14px;
  line-height: 18px;
  margin: 0;
}

.header {
  margin-bottom: 50px;
}

.logo {
  border-radius: 40px;
  width: 200px;
  height: 200px;
  display: flex;
  justify-content: center;
  margin: 0 auto 16px;
  background: rgba(255, 255, 255, 0.1);
  align-items: center;
}

button {
  background: white;
  display: block;
  color: #d61e2d;
  width: 100%;
  border: none;
  border-radius: 40px;
  padding: 12px 0;
  text-transform: uppercase;
  font-weight: bold;
  margin-bottom: 32px;
  outline: none;
}

.form-field {
  margin-bottom: 16px;
  width: 100%;
  position: relative;
}

.form-field .icon {
  position: absolute;
  background: white;
  color: #d61e2d;
  left: 0;
  top: 0;
  display: flex;
  align-items: center;
  height: 100%;
  width: 40px;
  height: 40px;
  justify-content: center;
  border-radius: 20px;
}

.form-field .icon:after {
  content: "";
  display: block;
  width: 0;
  height: 0;
  border: 12px solid transparent;
  border-left: 12px solid white;
  position: absolute;
  top: 8px;
  right: -20px;
}

.form-field input {
  border: 1px solid rgba(255, 255, 255, 0.2);
  text-align: center;
  width: 100%;
  border-radius: 16px;
  height: 36px;
  background: rgba(255, 255, 255, 0.1);
  color: white;
  outline: none;
  transition: all 0.2s;
}

.form-field input::placeholder {
  color: white;
}

.form-field input:hover,
.form-field input:focus {
  background: white;
  color: #d61e2d;
  transition: all 0.2s;
}

.form-field input:hover::placeholder {
  color: #d61e2d;
}

      </style>
   </head>
   <body>
       <div class="wrapper">

    <div class="login-card" id="xlogin">
        <div class="login-card-content">
            <div class="header">
                <div class="logo-img">
                    <img src="/images/siteImgs/logo.png" alt="">
                </div>
                <h2><span class="highlight">Habaybna</span></h2>
            </div>
            <div>
                @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                 @enderror
                <form method="POST" action="{{ route('check-otp') }}">
                    @csrf

                    <div class="form-field username">
                        <div class="icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <input id="otp" type="text"  name="otp" placeholder="Enter code" required  autofocus>

                    </div>
                    <button type="submit">
                        {{ __('Check') }}
                    </button>
                    <div>
                    {{-- Don't have an account? <a class="formNotice">Sign Up Now</a> --}}
                    </div>
                </form>
            </div>
            </div>
            <div class="login-card-footer">
            {{-- <a href="">Forgot password?</a> --}}
            </div>
      </div>
    </div>

   </body>
</html>
