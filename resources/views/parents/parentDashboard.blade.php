@extends('layouts.app')
@section('content')
        @if (Auth::user() && Auth::user()->role == 'parent')
            <parent-dashboard>

            </parent-dashboard>
        @endif
@endsection




