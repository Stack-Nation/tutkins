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
            <div class="col-lg-9">
                <ul class="nav text-uppercase nav-tabs">
                   <li class="nav-item"><a href="#" data-target="#overview" data-toggle="tab" class="nav-link text-capitalize active">Overview </a></li>
                   <li class="nav-item"><a href="#" data-target="#organiser" data-toggle="tab" class="nav-link text-capitalize">Organiser</a></li>
                   <li class="nav-item"><a href="#" data-target="#gallery" data-toggle="tab" class="nav-link text-capitalize">Gallery</a></li>
                   @if($event->mode==="Offline")<li class="nav-item"><a href="#" data-target="#location" data-toggle="tab" class="nav-link text-capitalize">Location</a></li>@endif
                   <li class="nav-item"><a href="#" data-target="#timings" data-toggle="tab" class="nav-link text-capitalize">Timings</a></li>
                </ul>
                <div class="tab-content mt-3">
                   <div id="overview" class="tab-pane fade  active show">
                       <div class="card">
                           <div class="card-header">
                               <h3 class="card-title">Description</h3>
                           </div>
                           <div class="card-body text-dark">
                                {!!$event->description!!}
                           </div>
                       </div>
                       <div class="card">
                           <div class="card-header">
                               <h3 class="card-title">Instructions</h3>
                           </div>
                           <div class="card-body text-dark">
                                {!!$event->instructions!!}
                           </div>
                       </div>
                   </div>
                   <div id="organiser" class="tab-pane fade">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Organiser</h3>
                        </div>
                        <div class="card-body text-dark">
                            <div class="media">
                                <img src="@if($event->organiser->photo===NULL) {{asset("assets/users/photo/default.png")}} @else {{asset("assets/users/photo/".$event->organiser->photo)}} @endif" alt="Author_Image" width="100px" class="img-fluid rounded">
                                <div class="media-body ml-4">
                                    <h2 class="text-capitalize">{{$event->organiser->name}}</h2>
                                    <p class="text-dark">
                                        {!!$event->organiser->description!!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                   </div>
                   <div id="gallery" class="tab-pane fade">
                       <div class="card">
                           <div class="card-header">
                               <h3 class="card-title">Gallery</h3>
                           </div>
                           <div class="card-body">
                               <div class="row">
                                   @foreach ($event->images as $image)
                                       <div class="col-lg-4">
                                            <img src="{{$image}}" alt="..." class="img-fluid">
                                       </div>
                                   @endforeach
                               </div>
                           </div>
                       </div>
                   </div>
                   @if($event->mode==="Offline")
                   <div id="location" class="tab-pane fade">
                       <div class="card">
                           <div class="card-header">
                               <h3 class="card-title">Location</h3>
                           </div>
                           <div class="card-body">
                               <p class="text-dark">Country: {{$event->country??"Not Set"}}</p>
                               <p class="text-dark">State: {{$event->state??"Not Set"}}</p>
                               <p class="text-dark">City: {{$event->city??"Not Set"}}</p>
                               <p class="text-dark">Address: {{$event->address??"Not Set"}}</p>
                               <p class="text-dark">Pin Code: {{$event->pin_code??"Not Set"}}</p>
                           </div>
                       </div>
                   </div>
                   @endif
                   <div id="timings" class="tab-pane fade">
                       <div class="card">
                           <div class="card-header">
                               <h3 class="card-title">Timings</h3>
                           </div>
                           <div class="card-body row">
                               <div class="col-lg-6">
                                   <h4>Dates</h4>
                                   <ul class="list-group">
                                    @foreach ($event->dates as $dates)
                                        <li class="list-group-item text-dark">{{\Carbon\Carbon::parse($dates)->format("d M Y")}}</li>
                                    @endforeach
                                   </ul>
                               </div>
                               <div class="col-lg-6">
                                    <h4>Time</h4>
                                    <ul class="list-group">
                                    @foreach ($event->times as $times)
                                        <li class="list-group-item text-dark">{{\Carbon\Carbon::parse($times)->format("h:i:s A")}}</li>
                                    @endforeach
                                    </ul>
                                </div>
                           </div>
                       </div>
                   </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <video src="{{asset("assets/events/video/".$event->video)}}" poster="{{asset("assets/events/thumbnail/".$event->thumbnail)}}" width="100%" height="150px" controls></video>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-3">
                            <li class="list-group-item text-dark">
                                <p class="float-left">Duration</p>
                                <p class="float-right">{{$event->duration}}</p>
                            </li>
                            <li class="list-group-item text-dark">
                                <p class="float-left">Number of days</p>
                                <p class="float-right">{{$event->days}}</p>
                            </li>
                            <li class="list-group-item text-dark">
                                <p class="float-left">Price</p>
                                <p class="float-right">{{$event->price==0?"Free":$event->price." INR"}}</p>
                            </li>
                        </ul>
                        <a href="#!" class="btn btn-success">Enroll Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection