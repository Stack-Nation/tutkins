@extends('layouts.authApp')
@section("title","Enrolled Events")
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Enrolled Events</h2>
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
                            <th>Slot</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                            <tr>
                                <td><a href="{{route("events.view",[$event->event->id,md5($event->event->title)])}}">{{$event->event->title}}</a></td>
                                <td>{{$event->event->category->name}}</td>
                                <td>{{$event->event->mode}}</td>
                                <td>{{$event->event->duration}}</td>
                                <td>{{$event->event->days}}</td>
                                <td>{{\Carbon\Carbon::parse($event->date)->format("d M Y")}} at {{\Carbon\Carbon::parse($event->time)->format("h:i:s A")}}</td>
                                @if($event->event->mode=="Online")<td><a href="{{$event->event->link}}" class="btn btn-info btn-sm">Join Now</a></td>@endif
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