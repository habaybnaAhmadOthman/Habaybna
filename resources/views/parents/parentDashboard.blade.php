@extends('layouts.app')
@section('content')
        @if (Auth::user() && Auth::user()->role == 'parent')
            <parent-dashboard>
                <router-view></router-view>
            </parent-dashboard>
        @endif
@endsection




