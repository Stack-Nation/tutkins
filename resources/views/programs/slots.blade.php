@extends('layouts.app')
@section("title",$program->title)
@section('content')
<div class="container-fluid">
    <div class="row bg-white p-4">
        <div class="col-12">
            <div class="media">
                <img src="{{asset("assets/programs/thumbnail/".$program->thumbnail)}}" alt="thumbnail" width="250px" class="img-fluid rounded">
                <div class="media-body ml-4">
                    <h2 class="text-capitalize">{{$program->title}}</h2>
                    <h5 class="text-dark "><i class="mdi mdi-clipboard-file"></i> {{$program->category->name}}</h5>
                    <h5 class="text-dark "><i class="mdi mdi-home-modern"></i> {{$program->mode}}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row p-4">
        <div class="col-md-12">
            <form action="{{route("programs.subscribe.add",$program->id)}}" method="post">
                 @csrf
                 <div class="form-group mb-3">
                     <label for="date">Select a date slot</label>
                     <input type="date" list="dates" onchange="document.getElementById('time').style.display='block'" name="date[]" class="form-control" multiple>
                     <datalist id="dates">
                        @foreach(json_decode($program->dates) as $date)
                        <option value="{{$date}}">{{$date}}</option>
                        @endforeach
                     </datalist>
                 </div>
                 <div id="time" style="display:none">
                    <div class="form-group mb-3">
                        <label for="time">Select a time slot</label>
                        <input type="time" list="times" name="time" class="form-control">
                        <datalist id="times">
                           @foreach(json_decode($program->times) as $time)
                           <option value="{{$time}}">{{$time}}</option>
                           @endforeach
                        </datalist>
                    </div>
                 </div>
                 <div id="type">
                    <div class="form-group mb-3">
                        <label for="type">Type</label>
                        <input type="text" list="types" name="type" class="form-control">
                        <datalist id="types">
                            <option value="">Select Type</option>
                            <option value="Trial">Trial</option>
                            <option value="Full">Full</option>
                        </datalist>
                    </div>
                 </div>
                 <button type="submit" class="btn btn-primary">Enroll</button>
            </form>
        </div>
    </div>
</div>
@endsection