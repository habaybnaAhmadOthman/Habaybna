
@extends('layouts.app')
@section('content')
    <div class="container-admin">
        @if (Auth::user() && Auth::user()->role == 'admin')
            @include('admin.layouts.sidebar')
            <div class="main">
                <div class="main-header">
                    <h1 class="main-title">Online Courses</h1><br>
                    <router-link to="/admin/course-create">About</router-link>
                </div>
                {{-- <div class="page-content container-fluid">
                    <div class="panel">
                        <div class="panel-body">
                            <video-info-component></video-info-component>
                        </div>
                    </div>
                </div> --}}
            </div>
        @endif
    </div>
@endsection
