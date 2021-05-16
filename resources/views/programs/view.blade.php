<?php
$ratings = 0;
$ratings5 = 0;
$ratings4 = 0;
$ratings3 = 0;
$ratings2 = 0;
$ratings1 = 0;
if($program->feedback === NULL){
    $ratings = 0;
}
else{
    $totalr = count($program->feedback);
    foreach ($program->feedback as $r) {
        $ratings = $ratings + (int)$r->stars;
        if((int)$r->stars===5){
            $ratings5++;
        }
        elseif((int)$r->stars===4){
            $ratings4++;
        }
        elseif((int)$r->stars===3){
            $ratings3++;
        }
        elseif((int)$r->stars===2){
            $ratings2++;
        }
        elseif((int)$r->stars===1){
            $ratings1++;
        }
    }
    $ratings = $ratings / $totalr;
    $ratings5 = (int)(($ratings5 / $totalr)*100);
    $ratings4 = (int)(($ratings4 / $totalr)*100);
    $ratings3 = (int)(($ratings3 / $totalr)*100);
    $ratings2 = (int)(($ratings2 / $totalr)*100);
    $ratings1 = (int)(($ratings1 / $totalr)*100);
}
?>
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
            <div class="col-lg-9">
                <ul class="nav text-uppercase nav-tabs">
                   <li class="nav-item"><a href="#" data-target="#overview" data-toggle="tab" class="nav-link text-capitalize active">Overview </a></li>
                   <li class="nav-item"><a href="#" data-target="#trainer" data-toggle="tab" class="nav-link text-capitalize">Trainer</a></li>
                   <li class="nav-item"><a href="#" data-target="#gallery" data-toggle="tab" class="nav-link text-capitalize">Gallery</a></li>
                   @if($program->mode==="Trainer's Location")<li class="nav-item"><a href="#" data-target="#location" data-toggle="tab" class="nav-link text-capitalize">Location</a></li>@endif
                   <li class="nav-item"><a href="#" data-target="#timings" data-toggle="tab" class="nav-link text-capitalize">Timings</a></li>
                   <li class="nav-item"><a href="#" data-target="#feedbacks" data-toggle="tab" class="nav-link text-capitalize">Feedbacks</a></li>
                </ul>
                <div class="tab-content mt-3">
                   <div id="overview" class="tab-pane fade  active show">
                       <div class="card">
                           <div class="card-header">
                               <h3 class="card-title">Description</h3>
                           </div>
                           <div class="card-body text-dark">
                                {!!$program->description!!}
                           </div>
                       </div>
                       <div class="card">
                           <div class="card-header">
                               <h3 class="card-title">Instructions</h3>
                           </div>
                           <div class="card-body text-dark">
                                {!!$program->instructions!!}
                           </div>
                       </div>
                   </div>
                   <div id="trainer" class="tab-pane fade">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Trainer</h3>
                        </div>
                        <div class="card-body text-dark">
                            <div class="media">
                                <img src="@if($program->trainer->photo===NULL) {{asset("assets/users/photo/default.png")}} @else {{asset("assets/users/photo/".$program->trainer->photo)}} @endif" alt="Author_Image" width="100px" class="img-fluid rounded">
                                <div class="media-body ml-4">
                                    <h2 class="text-capitalize"><a href="{{route("trainer.view-profile",$program->trainer->id)}}">{{$program->trainer->name}}</a></h2>
                                    <p class="text-dark">
                                        {!!$program->trainer->description!!}
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
                                   @foreach ($program->images as $image)
                                       <div class="col-lg-4">
                                            <img src="{{$image}}" alt="..." class="img-fluid">
                                       </div>
                                   @endforeach
                               </div>
                           </div>
                       </div>
                   </div>
                   @if($program->mode==="Trainer's Location")
                   <div id="location" class="tab-pane fade">
                       <div class="card">
                           <div class="card-header">
                               <h3 class="card-title">Location</h3>
                           </div>
                           <div class="card-body">
                               <p class="text-dark">Country: {{$program->country??($program->trainer->country??"Not Set")}}</p>
                               <p class="text-dark">State: {{$program->state??($program->trainer->state??"Not Set")}}</p>
                               <p class="text-dark">City: {{$program->city??($program->trainer->city??"Not Set")}}</p>
                               <p class="text-dark">Address: {{$program->address??($program->trainer->address??"Not Set")}}</p>
                               <p class="text-dark">Pin Code: {{$program->pin_code??($program->trainer->pin_code??"Not Set")}}</p>
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
                                    @foreach ($program->dates as $dates)
                                        <li class="list-group-item text-dark">{{\Carbon\Carbon::parse($dates)->format("d M Y")}}</li>
                                    @endforeach
                                   </ul>
                               </div>
                               <div class="col-lg-6">
                                    <h4>Time</h4>
                                    <ul class="list-group">
                                    @foreach ($program->times as $times)
                                        <li class="list-group-item text-dark">{{\Carbon\Carbon::parse($times)->format("h:i:s A")}}</li>
                                    @endforeach
                                    </ul>
                                </div>
                           </div>
                       </div>
                   </div>
                   <div id="feedbacks" class="tab-pane fade">
                       <div class="card">
                           <div class="card-header">
                               <h3 class="card-title">Feedbacks</h3>
                           </div>
                           <div class="card-body">
                            <div class="row mb-32pt">
                                <div class="col-md-3 mb-32pt mb-md-0">
                                    <div class="display-1">{{$ratings}}</div>
                                    <div class="rating rating-24">
                                        <div id="fratings" style="font-size:1rem" data-rating-value="{{$ratings}}"></div>
                                    </div>
                                    <p class="text-muted mb-0">{{$program->feedback===NULL ? 0: count($program->feedback)}} ratings</p>
                                </div>
                                <div class="col-md-9">
                    
                                    <div class="row align-items-center mb-8pt"
                                         data-toggle="tooltip"
                                         data-title="{{$ratings5}}% rated 5/5"
                                         data-placement="top">
                                        <div class="col-md col-sm-6">
                                            <div class="progress"
                                                 style="height: 8px;">
                                                <div class="progress-bar bg-primary"
                                                     role="progressbar"
                                                     aria-valuenow="{{$ratings5}}"
                                                     style="width: {{$ratings5}}%"
                                                     aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
                                            <div class="rating">
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-8pt"
                                         data-toggle="tooltip"
                                         data-title="{{$ratings4}}% rated 4/5"
                                         data-placement="top">
                                        <div class="col-md col-sm-6">
                                            <div class="progress"
                                                 style="height: 8px;">
                                                <div class="progress-bar bg-primary"
                                                     role="progressbar"
                                                     aria-valuenow="{{$ratings4}}"
                                                     style="width: {{$ratings4}}%"
                                                     aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
                                            <div class="rating">
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-8pt"
                                         data-toggle="tooltip"
                                         data-title="{{$ratings3}}% rated 3/5"
                                         data-placement="top">
                                        <div class="col-md col-sm-6">
                                            <div class="progress"
                                                 style="height: 8px;">
                                                <div class="progress-bar bg-primary"
                                                     role="progressbar"
                                                     aria-valuenow="{{$ratings3}}"
                                                     style="width: {{$ratings3}}%"
                                                     aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
                                            <div class="rating">
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-8pt"
                                         data-toggle="tooltip"
                                         data-title="{{$ratings2}}% rated 2/5"
                                         data-placement="top">
                                        <div class="col-md col-sm-6">
                                            <div class="progress"
                                                 style="height: 8px;">
                                                <div class="progress-bar bg-primary"
                                                     role="progressbar"
                                                     aria-valuenow="{{$ratings2}}"
                                                     style="width: {{$ratings2}}%"
                                                     aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
                                            <div class="rating">
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mb-8pt"
                                         data-toggle="tooltip"
                                         data-title="{{$ratings1}}% rated 0/5"
                                         data-placement="top">
                                        <div class="col-md col-sm-6">
                                            <div class="progress"
                                                 style="height: 8px;">
                                                <div class="progress-bar bg-primary"
                                                     role="progressbar"
                                                     aria-valuenow="{{$ratings1}}"
                                                     style="width: {{$ratings1}}%"
                                                     aria-valuemin="0"
                                                     aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-auto col-sm-6 d-none d-sm-flex align-items-center">
                                            <div class="rating">
                                                <span class="rating__item"><span class="material-icons">star</span></span>
                                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                                <span class="rating__item"><span class="material-icons">star_border</span></span>
                                            </div>
                                        </div>
                                    </div>
                    
                                </div>
                            </div>
                            
                            @if($program->feedback === NULL)
                                <p>No feedback found.</p>
                            @else
                            @foreach($program->feedback as $f)
                            <?php
                                $student = \App\Models\User::find($f->user_id)
                            ?>
                            <div class="pb-16pt mb-16pt border row shadow-sm p-3">
                                <div class="col-md-3 mb-16pt mb-md-0">
                                    <div class="d-flex">
                                        <a href="student-profile.html"
                                           class="avatar avatar-sm mr-12pt">
                                            <!-- <img src="LB" alt="avatar" class="avatar-img rounded-circle"> -->
                                            <span class="avatar-title rounded-circle">
                                                <img src="@if($student->photo===NULL) {{asset("assets/users/photo/default.png")}} @else {{asset("assets/users/photo/".$student->photo)}} @endif"
                                                alt="{{$f->user_id}}"
                                                class="rounded-circle"
                                                width="64">
                                            </span>
                                        </a>
                                        <div class="flex">
                                            <a href="#!"
                                               class="card-title">{{$student->name}}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="rating mb-8pt">
                                        <div class="uratings" style="font-size:1rem" data-rating-value="{{$f->stars}}"></div>
                                    </div>
                                    {!!$f->feedback!!}
                                </div>
                            </div>
                            <br>
                            @endforeach
                            @endif
                           </div>
                       </div>
                   </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <video src="{{asset("assets/programs/video/".$program->video)}}" poster="{{asset("assets/programs/thumbnail/".$program->thumbnail)}}" width="100%" height="150px" controls></video>
                    </div>
                    <div class="card-body">
                        <ul class="list-group mb-3">
                            <li class="list-group-item text-dark">
                                <p class="float-left">Duration</p>
                                <p class="float-right">{{$program->duration}}</p>
                            </li>
                            <li class="list-group-item text-dark">
                                <p class="float-left">Number of classes</p>
                                <p class="float-right">{{$program->classes}}</p>
                            </li>
                            <li class="list-group-item text-dark">
                                <p class="float-left">Trial Price</p>
                                <p class="float-right">{{$program->trial_price==0?"Free":$program->trial_price." INR"}}</p>
                            </li>
                            <li class="list-group-item text-dark">
                                <p class="float-left">Price</p>
                                <p class="float-right">{{$program->price==0?"Free":$program->price." INR"}}</p>
                            </li>
                        </ul>
                        @auth
                        @if(Auth::user()->enrolled_programs->where("program_id",$program->id)->first()!==NULL)
                            @if((new DateTime(Auth::user()->enrolled_programs->where("program_id",$program->id)->first()->date." ".Auth::user()->enrolled_programs->where("program_id",$program->id)->first()->time))<=(new DateTime("NOW")))
                            <a class="btn btn-success" href="{{$program->link}}">Join Now</a>
                            @else
                            <p>Join in: <strong id="timer"></strong></p>
                            @endif
                        @else
                            <a class="btn btn-success" href="{{route("programs.subscribe.slot",$program->id)}}">Enroll Now</a>
                        @endif
                         @else
                         <a class="btn btn-success" href="{{route("login")}}">Login</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@auth
   @if(Auth::user()->enrolled_programs->where("program_id",$program->id)->first()!==NULL)
         @if((new DateTime(Auth::user()->enrolled_programs->where("program_id",$program->id)->first()->date." ".Auth::user()->enrolled_programs->where("program_id",$program->id)->first()->time))>(new DateTime("NOW")))
         <script>
            var countDownDate = new Date('{{Auth::user()->enrolled_programs->where("program_id",$program->id)->first()->date." ".Auth::user()->enrolled_programs->where("program_id",$program->id)->first()->time}}').getTime();
            // Update the count down every 1 second
            var x = setInterval(function() {
            
               // Get today's date and time
               var now = new Date().getTime();
            
               // Find the distance between now and the count down date
               var distance = countDownDate - now;
            
               // Time calculations for days, hours, minutes and seconds
               var days = Math.floor(distance / (1000 * 60 * 60 * 24));
               var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
               var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
               var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
               // Display the result in the element with id="timer"
               document.getElementById("timer").innerHTML = days + "d " + hours + "h "
               + minutes + "m " + seconds + "s ";
            
               // If the count down is finished, write some text
               if (distance < 0) {
               clearInterval(x);
               document.getElementById("timer").innerHTML = `<a href="{{$program->link}}">Join Now</a>`;
               }
            }, 1000);
         </script>
         @endif
   @endif
@endauth
<script src="{{asset("assets/rating/rating.js")}}"></script>
<script>
    window.onload = () => { 
        const stars = $("#ratings").data("rating-value");
        $("#ratings").rating({
            readonly:true,
            value:stars
        }); 
        const fstars = $("#fratings").data("rating-value");
        $("#fratings").rating({
            readonly:true,
            value:fstars
        });
        const uratings = $(".uratings");
        uratings.map((key,urating) => {
            let ustars = $(urating).data("rating-value");
            $(urating).rating({
                readonly:true,
                value:ustars
            });
        })
    }
</script>
@endsection