@extends('layouts.app')
@section("title",$program->title)
@section('head')
<link rel="stylesheet" href="{{asset("assets/main/assets/plugins/select2/css/select2.min.css")}}">
@endsection
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
                 @if($type=="Full")
                 <div class="form-group mb-3">
                     <label for="day">Select a day</label>
                     <select name="day[]" id="day" class="custom-select custom-select-lg dropdown-groups" onchange="document.getElementById('time').style.display='block'" multiple>
                        @foreach(json_decode($program->days) as $day)
                        <option value="{{$day}}">{{$day}}</option>
                        @endforeach
                     </select>
                 </div>
                 <div id="time" style="display:none">
                    <div class="form-group mb-3">
                        <label for="time">Select a time slot</label>
                        <select name="time[]" id="time" class="custom-select custom-select-lg dropdown-groups" multiple>
                            @foreach(json_decode($program->times) as $time)
                            <option value="{{$time}}">{{$time}}</option>
                            @endforeach
                        </select>
                    </div>
                 </div>
                 @elseif($type=="Trial")
                 <div class="form-group mb-3">
                     <label for="day">Select a date</label>
                     <select name="day[]" id="day" class="custom-select custom-select-lg dropdown-groups" onchange="document.getElementById('time').style.display='block'" multiple>
                        @foreach(json_decode($program->trial_dates) as $day)
                        <option value="{{$day}}">{{$day}}</option>
                        @endforeach
                     </select>
                 </div>
                 <div id="time" style="display:none">
                    <div class="form-group mb-3">
                        <label for="time">Select a time slot</label>
                        <select name="time[]" id="time" class="custom-select custom-select-lg dropdown-groups" multiple>
                            @foreach(json_decode($program->trial_times) as $time)
                            <option value="{{$time}}">{{$time}}</option>
                            @endforeach
                        </select>
                    </div>
                 </div>
                 @endif
                 <div id="type">
                     <input type="hidden" name="type" value="{{$type}}">
                 </div>
                 <button type="submit" class="btn btn-primary">Enroll</button>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset("assets/main/assets/plugins/select2/js/select2.full.min.js")}}"></script>
<script src="{{asset("assets/main/js/plugins-init/select2-init.js")}}"></script>
@endsection