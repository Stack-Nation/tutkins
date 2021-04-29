@extends('layouts.authApp')
@section("title","Trainer Programs")
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">All Programs</h2>
                <a href="{{route("trainer.programs.create")}}" class="btn btn-primary ml-4 btn-sm" role="button">Create a program</a>
            </div>
            <div class="card-body">
                @if($programs->count()>0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Mode</th>
                            <th>Duration</th>
                            <th>Number of classes</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($programs as $program)
                            <tr>
                                <td>{{$program->title}}</td>
                                <td>{{$program->category->name}}</td>
                                <td>{{$program->mode}}</td>
                                <td>{{$program->duration}}</td>
                                <td>{{$program->classes}}</td>
                                @if($program->mode=="Online")<td><a href="{{$program->link}}" class="btn btn-info btn-sm">Join Now</a></td>@endif
                                <td>
                                    <a href="{{route("trainer.programs.subscribers",$program->id)}}" class="btn btn-success btn-sm">Manage Subscribers</a>
                                </td>
                                <td>
                                    <a href="{{route("trainer.programs.edit",$program->id)}}" class="btn btn-success btn-sm">Edit</a>
                                </td>
                                <td>
                                    <form action="{{route("trainer.programs.delete")}}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$program->id}}">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
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