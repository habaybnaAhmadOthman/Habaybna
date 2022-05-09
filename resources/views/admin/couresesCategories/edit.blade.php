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
                                    <h3 class="mb-0">Update Category</h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('category.update', $category->id) }}" autocomplete="off"
                                        class="form" role="form" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="inputPasswordOld">Category Title</label>
                                            <input class="form-control" required="" type="text" name="title"
                                                value="{{ $category->title }}">
                                            <small class="form-text text-muted" id="passwordHelpBlock">Your category must be
                                                8-20 characters long, contain letters , and must not contain
                                                special characters, or emoji.</small>
                                        </div>
                                        <label for="status">Category Staus </label>

                                        <div class="form-group">
                                            <div class="btn-group" data-toggle="buttons" role="group">


                                                <label class="btn btn-outline btn-success">
                                                    <input type="radio" id="status" name="status" autocomplete="off"
                                                        value="1" @if ($category->status) ? checked @endif />
                                                    <i class="icon wb-check text-active" aria-hidden="true"></i> Active
                                                </label>
                                                <label class="btn btn-outline btn-danger">
                                                    <input type="radio" id="status" name="status" autocomplete="off"
                                                        value="0" @if (!$category->status) ? checked @endif />
                                                    <i class="icon wb-check text-active" aria-hidden="true"></i> Deactive
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-success btn-lg float-right" type="submit">Update</button>
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
