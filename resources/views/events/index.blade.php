@extends('layouts.app')
@section("title","Events")
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Events</h1>
            <hr>
            <form action="{{route("events.search")}}" method="post">
                @csrf
                <div class="col-md-4 mb-2">
                    <input type="text" class="form-control" id="city" name="city" placeholder="City">
                </div>
                <div class="col-md-4 mb-2">
                    <input type="text" class="form-control" id="age_group" name="age_group" placeholder="Age Group">
                </div>
                <div class="col-md-4 mb-2">
                    <select name="category" id="category" class="custom-select">
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Filter</button>
                </div>
            </form>
        </div>
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