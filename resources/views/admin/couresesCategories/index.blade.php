@extends('layouts.app')
@section('content')

    <div class="container-admin">
        @if (Auth::user() && Auth::user()->role == 'admin')
            @include('admin.layouts.sidebar')
            <div class="main">
                <div class="main-header">
                    <h1 class="main-title">Courses Categories</h1><br>
                    <a href="{{ route('category.create') }}" class="btn btn-outline-primary">+ Add new Category</a>
                </div>
                <div class="page-content container-fluid">
                    <div class="panel">
                        <div class="panel-body">
                            <table id="admin-table" class="table table-striped table-bordered admin-table" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($categories->count() > 0)
                                        @php
                                            $i = 0
                                        @endphp
                                        @foreach ($categories as $item)
                                        <tr>
                                            <td>{{++$i}}-</td>
                                            <td>{{$item->title}}</td>
                                            <td>{{$item->status ? 'Active' : 'Deactive'}}</td>
                                            <td>
                                                <div class="actions-options">
                                                    <a href="{{route('category.edit',$item->id)}}"><img src="{{asset('icons/edit.svg')}}" alt="edit" srcset=""></a>
                                                    <a href="#"><img src="{{asset('icons/delete.svg')}}" alt="delete" srcset=""></a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                    @else
                                        <tr>No data</tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>



@endsection

@section('js-files')




@stop

@section('js-script')

@stop
