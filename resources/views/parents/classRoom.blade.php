@extends('layouts.app')
@section('content')
        @if (Auth::user() && Auth::user()->role == 'parent')
            <class-room></class-room>
        @endif
@endsection
