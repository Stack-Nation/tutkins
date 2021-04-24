@extends('layouts.app')
@section("title",$event->title)
@section('content')
<div class="container-fluid">
    <div class="row bg-white p-4">
        <div class="col-12">
            <div class="media">
                <img src="{{asset("assets/events/thumbnail/".$event->thumbnail)}}" alt="thumbnail" width="250px" class="img-fluid rounded">
                <div class="media-body ml-4">
                    <h2 class="text-capitalize">{{$event->title}}</h2>
                    <h5 class="text-dark "><i class="mdi mdi-clipboard-file"></i> {{$event->category->name}}</h5>
                    <h5 class="text-dark "><i class="mdi mdi-home-modern"></i> {{$event->mode}}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row p-4">
        <div class="col-md-12">
            <form action="{{route("events.subscribe.add",$event->id)}}" method="post">
                 @csrf
                 <div class="form-group mb-3">
                     <label for="date">Select a date slot</label>
                     <input type="date" list="dates" onchange="document.getElementById('time').style.display='block'" name="date" class="form-control">
                     <datalist id="dates">
                        @foreach(json_decode($event->dates) as $date)
                        <option value="{{$date}}">{{$date}}</option>
                        @endforeach
                     </datalist>
                 </div>
                 <div id="time" style="display:none">
                    <div class="form-group mb-3">
                        <label for="time">Select a time slot</label>
                        <input type="time" list="times" name="time" class="form-control">
                        <datalist id="times">
                           @foreach(json_decode($event->times) as $time)
                           <option value="{{$time}}">{{$time}}</option>
                           @endforeach
                        </datalist>
                    </div>
                 </div>
                 <button type="submit" class="btn btn-primary">Enroll</button>
            </form>
        </div>
    </div>
</div>
@endsection