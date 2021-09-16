@extends('layouts.app')
@section('content')

    <div class="container-admin">
        @if (Auth::user() && Auth::user()->role == 'admin')
            @include('admin.layouts.sidebar')
            <div class="main">
                <div class="main-header">
                    <h1 class="main-title">Courses Categories</h1><br>
                    <a href="{{ route('coursesCategories') }}" class="btn btn-outline-dark">back</a>
                </div>

                <div class="page-content container-fluid">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="card card-outline-secondary">
                                <div class="card-header">
                                    <h3 class="mb-0">Create new Category</h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('category.store') }}" autocomplete="off" class="form"
                                        role="form" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="inputPasswordOld">Category Title</label>
                                            <input class="form-control" required="" type="text" name="title">
                                            <small class="form-text text-muted" id="passwordHelpBlock">Your category must be
                                                8-20 characters long, contain letters , and must not contain
                                                special characters, or emoji.</small>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-success btn-lg float-right" type="submit">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>



@endsection
