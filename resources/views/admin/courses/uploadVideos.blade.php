@extends('layouts.app')
@section('content')

    <div class="container-admin">
        @if (Auth::user() && Auth::user()->role == 'admin')
            @include('admin.layouts.sidebar')
            <div class="main">
                <div class="main-header">
                    <h1 class="main-title">Create a new Course</h1><br>

                </div>

                <div class="page-content container-fluid">
                    <div class="panel">
                        <div class="panel-body">
                            {{-- <video-info-component :categories= "{{json_encode($categories)}}"></video-info-component> --}}
                            <router-view></router-view>

                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>



@endsection
