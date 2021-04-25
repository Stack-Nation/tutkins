@extends('layouts.authApp')
@section("title","All Events")
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">All Events</h2>
            </div>
            <div class="card-body">
                @if($events->count()>0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Created By</th>
                            <th>Category</th>
                            <th>Mode</th>
                            <th>Duration</th>
                            <th>Number of days</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                            <tr>
                                <td>{{$event->title}}</td>
                                <td>{{$event->orgraniser->name}}</td>
                                <td>{{$event->category->name}}</td>
                                <td>{{$event->mode}}</td>
                                <td>{{$event->duration}}</td>
                                <td>{{$event->days}}</td>
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