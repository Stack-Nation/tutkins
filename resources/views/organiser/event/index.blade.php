@extends('layouts.authApp')
@section("title","Trainer Events")
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">All Events</h2>
                <a href="{{route("organiser.events.create")}}" class="btn btn-primary ml-4 btn-sm" role="button">Create a event</a>
            </div>
            <div class="card-body">
                @if($events->count()>0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Mode</th>
                            <th>Duration</th>
                            <th>Number of days</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                            <tr>
                                <td>{{$event->title}}</td>
                                <td>{{$event->category->name}}</td>
                                <td>{{$event->mode}}</td>
                                <td>{{$event->duration}}</td>
                                <td>{{$event->days}}</td>
                                <td>
                                    <a href="{{route("organiser.events.edit",$event->id)}}" class="btn btn-success btn-sm">Edit</a>
                                </td>
                                <td>
                                    <form action="{{route("organiser.events.delete")}}" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$event->id}}">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-dark">No events found</p>
                @endif
                {{$events->links()}}
            </div>
        </div>
    </div>
</div>
@endsection