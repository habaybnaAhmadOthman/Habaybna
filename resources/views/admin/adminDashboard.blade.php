@extends('layouts.app')
@section('content')
        @if (Auth::user() && Auth::user()->role == 'admin')
            <admin-dashboard>
                <router-view></router-view>
            </admin-dashboard>
        @endif
@endsection


