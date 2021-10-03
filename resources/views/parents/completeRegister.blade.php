@extends('layouts.app')
<style>
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
.wrapper{
    text-align: center
}
.form-wrapper{
    max-width: 60%;
    text-align: center;
    align-items: center;
    margin: auto;
}
.form-wrapper label {
    color: aliceblue
}
.form-wrapper button {
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
.form-wrapper button:hover {
  background: #d61e2d;
}

</style>
@section('content')

                <div class="wrapper">
                    <div class="header">
                        <div class="logo-img">
                            <img src="/images/siteImgs/logo.png" alt="">
                        </div>
                        <h2><span class="highlight">Habaybna</span></h2>
                    </div>
                    <div class="form-wrapper">
                        <form  method="POST" action="{{ route('parent.completeRegister') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label for="firstName" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>

                                <div class="col-md-6">
                                   <input type="text" name="firstName" class="form-control">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lastName" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>

                                <div class="col-md-6">
                                   <input type="text" name="lastName" class="form-control">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('gender') }}</label>

                                <div class="col-md-6">
                                    <select name="gender" id="gender" class="form-control">
                                        <option value="" selected>Select your gender</option>
                                        <option value="m">Male</option>
                                        <option value="f">Female</option>
                                    </select>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="firstName" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                   <input type="password" name="password" class="form-control">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="dob" class="col-md-4 col-form-label text-md-right">{{ __('Date Of Birth') }}</label>

                                <div class="col-md-6">
                                    <input id="dob" name="dob" type="date" class="form-control">

                                    @error('dob')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Profile Image') }}</label>

                                <div class="col-md-6">
                                    <input id="avatar" type="file" class="form-control" name="image">

                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Complete Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
@endsection
