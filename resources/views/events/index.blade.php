@extends('layouts.app')
@section("title","Events")
@section('content')
    <div class="container">
        <div class="text-center"> 
            <h1>Events</h1>
            <hr>
        </div>
    </div>
    <div class="container">
        @if($events->count()===0)
        <p class="text-dark">No event found</p>
        @else
        <div class="row">
            @foreach ($events as $event)
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <img src="{{asset("assets/events/thumbnail/".$event->thumbnail)}}" alt="..." class="img-fluid">
                    </div>
                    <div class="card-body">
                        <h3><a href="{{route("events.view",[$event->id,md5($event->title)])}}">{{$event->title}}</a></h3>
                        <h5><i class="mdi mdi-human-male"></i> {{$event->organiser->name}}</h5>
                        <p class="text-dark float-left"><i class="mdi mdi-clipboard-file"></i> {{$event->category->name}}</p>
                        <p class="text-dark float-right"><i class="mdi mdi-currency-inr"></i> {{$event->price}}</p>
                        <a href="{{route("events.view",[$event->id,md5($event->title)])}}" class="btn btn-block btn-success btn-sm float-right">View</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
        {{$events->links()}}
    </div>
@endsection