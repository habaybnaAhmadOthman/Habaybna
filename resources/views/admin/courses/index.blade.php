{{-- @extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Online Courses </h1>
                <upload-video></upload-video>

            </div>
        </div>

    </div>
    @endsection --}}
@extends('layouts.app')
@section('content')

    <div class="container-admin">
        @if (Auth::user() && Auth::user()->role == 'admin')
            @include('admin.layouts.sidebar')
            <div class="main">
                <div class="main-header">
                    <h1 class="main-title">Online Courses</h1><br>
                    <a href="{{route('course.create')}}" class="btn btn-outline-primary">+ Add new course</a>
                    {{-- <button type="button" class="btn btn-outline-secondary">Secondary</button>
                    <button type="button" class="btn btn-outline-success">Success</button>
                    <button type="button" class="btn btn-outline-danger">Danger</button>
                    <button type="button" class="btn btn-outline-warning">Warning</button>
                    <button type="button" class="btn btn-outline-info">Info</button>
                    <button type="button" class="btn btn-outline-light">Light</button>
                    <button type="button" class="btn btn-outline-dark">Dark</button> --}}
                </div>

                <div class="page-content container-fluid">
                    <div class="panel">
                        <div class="panel-body">

                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>



@endsection
