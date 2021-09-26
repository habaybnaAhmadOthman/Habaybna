@extends('layouts.app')
@section('content')
        @if (Auth::user() && Auth::user()->role == 'admin')
            <admin-dashboard>

            </admin-dashboard>
        @endif
@endsection


