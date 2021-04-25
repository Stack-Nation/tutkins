@extends('layouts.authApp')
@section("title","All Programs")
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">All Programs</h2>
            </div>
            <div class="card-body">
                @if($programs->count()>0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Created By</th>
                            <th>Category</th>
                            <th>Mode</th>
                            <th>Duration</th>
                            <th>Number of classes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($programs as $program)
                            <tr>
                                <td>{{$program->title}}</td>
                                <td>{{$program->trainer->name}}</td>
                                <td>{{$program->category->name}}</td>
                                <td>{{$program->mode}}</td>
                                <td>{{$program->duration}}</td>
                                <td>{{$program->classes}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-dark">No programs found</p>
                @endif
                {{$programs->links()}}
            </div>
        </div>
    </div>
</div>
@endsection