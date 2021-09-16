@extends('layouts.app')
@section('content')

    <div class="container-admin">
        @if (Auth::user() && Auth::user()->role == 'admin')
            @include('admin.layouts.sidebar')
            <div class="main">
                <div class="main-header">
                    <h1 class="main-title">Dashboard</h1>
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
