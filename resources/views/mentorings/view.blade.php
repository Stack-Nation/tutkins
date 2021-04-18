<?php
   $date = new DateTime($mentoring->created_at);
?>
@extends('layouts.courses')
@section("title",$mentoring->title)
@section('content')
<section id="yl-breadcrumb" class="yl-breadcrumb-section position-relative" data-background="{{asset("assets/mentorings/thumbnail/".$mentoring->thumbnail)}}">
   <span class="breadcrumb-overlay position-absolute"></span>
   <div class="container">
      <div class="yl-breadcrumb-content text-center yl-headline"> 
         <h2>{{$mentoring->title}}</h2>
         <div class="yl-breadcrumb-item ul-li">
            <ul class="breadcrumb">
             <li class="breadcrumb-item"><a href="{{route("home")}}">Home</a></li>
             <li class="breadcrumb-item active" aria-current="page">Mentoring programs</li>
          </ul>
       </div>
    </div>
 </div>
</section>
<section id="course-details" class="course-details-section">
   <div class="container">
      <div class="course-details-content">
         <div class="row">
            <div class="col-lg-9">
               <div class="course-details-tab-area">
                  <div class="course-details-tab-wrapper">
                     <div class="course-details-tab-btn clearfix ul-li">
                        <ul id="tabs" class="nav text-uppercase nav-tabs">
                           <li class="nav-item"><a href="#" data-target="#overview" data-toggle="tab" class="nav-link text-capitalize active">Overview </a></li>
                           <li class="nav-item"><a href="#" data-target="#instructor" data-toggle="tab" class="nav-link text-capitalize">Author</a></li>
                        </ul>
                     </div>
                     <div class="course-details-tab-content-wrap">
                        <div id="tabsContent" class="tab-content">
                           <div id="overview" class="tab-pane fade  active show">
                              <div class="course-details-overview yl-headline pera-content">
                                 <div class="course-overview-text">
                                    <h3 class="c-overview-title">Program details</h3>
                                    <div>{!!$mentoring->description!!}</div>
                                 </div>
                                 <div class="course-details-overview-feature">
                                    <h3 class="c-overview-title">Availability</h3>
                                    <ul class="list-group list-group-flush">
                                        @for($i = 0;$i<$mentoring->availability;$i++)
                                            <li class="list-group-item">
                                                <span class="text-70">{{\Carbon\Carbon::parse($date->add(new DateInterval('P1D')))->format("d-m-Y")}}</span>
                                            </li>
                                        @endfor
                                    </ul>
                                 </div>
                              </div>
                           </div>
                           <div id="instructor" class="tab-pane fade">
                              <div class="cd-course-instructor yl-headline pera-content clearfix">
                                 <h3 class="c-overview-title">Webinar Author</h3>
                                 <div class="cd-course-instructor-img-text clearfix">
                                    <div class="cd-course-instructor-img float-left">
                                       <img src="@if($mentoring->owner->photo===NULL) {{asset("assets/users/photo/default.png")}} @else {{asset("assets/users/photo/".$mentoring->owner->photo)}} @endif" alt="">
                                    </div>
                                    <div class="cd-course-instructor-text">
                                       <h3><a href="{{route("user.view",[$mentoring->owner->id,md5($mentoring->owner->name)])}}">{{$mentoring->owner->name}}</a></h3>
                                       <div class="cd-ins-course-student">
                                          <span><i class="fas fa-list-ul"></i> {{$mentoring->owner->mentorings->count()}} Mentoring programs</span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="cd-ins-details">
                                    {!!$mentoring->owner->description!!}
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-3">
               <div class="course-details-widget">
                  <div class="course-widget-wrap">
                     <div class="cd-video-widget position-relative">
                        <img src="{{asset("assets/mentorings/thumbnail/".$mentoring->thumbnail)}}" alt="">
                        <a class="video_box text-center" href="#"><i class="fas fa-play"></i></a>
                     </div>
                  </div>
                  <div class="course-widget-wrap">
                     <div class="cd-course-table-widget">
                        <div class="cd-course-table-list">
                           <div class="course-table-item clearfix">
                              <span class="cd-table-title float-left"><i class="fas fa-clock"></i> Last Updated : </span>
                              <span class="cd-table-valur float-right">{{\Carbon\Carbon::parse($mentoring->updated_at)->diffForHumans()}}</span>
                           </div>
                           <div class="course-table-item clearfix">
                              <span class="cd-table-title float-left"><i class="fas fa-users"></i> Subscribers  : </span>
                              <span class="cd-table-valur float-right">{{$mentoring->enrolled_users->count()}}</span>
                           </div>
                           <div class="course-table-item clearfix">
                              <span class="cd-table-title float-left"><i class="material-icons text-muted icon--left">category</i> Category  : </span>
                              <span class="cd-table-valur float-right">{{$mentoring->category->name}}</span>
                           </div>
                           <div class="course-table-item clearfix">
                              <span class="cd-table-title float-left">Duration  : </span>
                              <span class="cd-table-valur float-right">{{$mentoring->duration}}</span>
                           </div>
                        </div>
                        <div class="cd-course-price clearfix">
                           <p>Price: <strong>{{$mentoring->price==0?"FREE":$mentoring->price." INR"}}</strong></p>
                           @auth
                           @if(Auth::user()->enrolled_mentorings->where("mentoring_id",$mentoring->id)->first()!==NULL)
                               @if(Auth::user()->enrolled_mentorings->where("mentoring_id",$mentoring->id)->first()->form_response===NULL)
                                   <a href="{{route("mentorings.subscribe.fill-form",$mentoring->id)}}">Fill Form</a>
                               @else
                                 @if((new DateTime(Auth::user()->enrolled_mentorings->where("mentoring_id",$mentoring->id)->first()->date." ".Auth::user()->enrolled_mentorings->where("mentoring_id",$mentoring->id)->first()->time))<=(new DateTime("NOW")))
                                   <a href="{{$mentoring->link}}">Join Now</a>
                                 @else
                                   <p>Join in: <strong id="timer"></strong></p>
                                 @endif
                               @endif
                           @else
                               <a href="{{route("mentorings.subscribe.slot",$mentoring->id)}}">Subscribe Now</a>
                           @endif
                            @else
                            <a href="{{route("login")}}">Login</a>
                           @endauth
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection
@section('scripts')
@auth
   @if(Auth::user()->enrolled_mentorings->where("mentoring_id",$mentoring->id)->first()!==NULL)
      @if(Auth::user()->enrolled_mentorings->where("mentoring_id",$mentoring->id)->first()->form_response!==NULL)
         @if((new DateTime(Auth::user()->enrolled_mentorings->where("mentoring_id",$mentoring->id)->first()->date." ".Auth::user()->enrolled_mentorings->where("mentoring_id",$mentoring->id)->first()->time))>(new DateTime("NOW")))
         <script>
            var countDownDate = new Date('{{Auth::user()->enrolled_mentorings->where("mentoring_id",$mentoring->id)->first()->date." ".Auth::user()->enrolled_mentorings->where("mentoring_id",$mentoring->id)->first()->time}}').getTime();
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
               document.getElementById("timer").innerHTML = `<a href="{{$mentoring->link}}">Join Now</a>`;
               }
            }, 1000);
         </script>
         @endif
      @endif
   @endif
@endauth
@endsection