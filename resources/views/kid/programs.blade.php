@extends('layouts.authApp')
@section("title","Enrolled Programs")
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Enrolled Programs</h2>
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
                            <th>Trainer's Name</th>
                            <th>Type</th>
                            <th>Slot</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($programs as $program)
                            <tr>
                                <td><a href="{{route("programs.view",[$program->program->id,md5($program->program->title)])}}">{{$program->program->title}}</a></td>
                                <td>{{$program->program->category->name}}</td>
                                <td>{{$program->program->mode}}</td>
                                <td>{{$program->program->duration}}</td>
                                <td>{{$program->program->trainer->name}}</td>
                                <td>{{$program->type}}</td>
                                <td>{{$program->day}} at {{$program->time)}}</td>
                                <td><a href="{{route("programs.subscribe.feedback",$program->program->id)}}" class="btn btn-warning btn-sm">Feedback</a></td>
                                @if($program->program->mode=="Online")<td><a href="{{$program->program->link}}" class="btn btn-info btn-sm">Join Now</a></td>@endif
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