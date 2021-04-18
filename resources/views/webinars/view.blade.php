<?php
 $dur = new DateTime($webinar->date." ".$webinar->time);
 $now = new DateTime("NOW");
 $discount = $webinar->price * $webinar->discount/100;
?>
@extends('layouts.courses')
@section("title",$webinar->title)
@section('content')
<section id="yl-breadcrumb" class="yl-breadcrumb-section position-relative" data-background="{{asset("assets/webinars/thumbnail/".$webinar->thumbnail)}}">
   <span class="breadcrumb-overlay position-absolute"></span>
   <div class="container">
      <div class="yl-breadcrumb-content text-center yl-headline"> 
         <h2>{{$webinar->title}}</h2>
         <div class="yl-breadcrumb-item ul-li">
            <ul class="breadcrumb">
             <li class="breadcrumb-item"><a href="{{route("home")}}">Home</a></li>
             <li class="breadcrumb-item active" aria-current="page">{{$webinar->category->name}}</li>
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
                                    <h3 class="c-overview-title">Webinar details</h3>
                                    <div>{!!$webinar->description!!}</div>
                                 </div>
                                 <div class="course-details-overview-feature">
                                    <h3 class="c-overview-title">Images</h3>
                                    <div class="row">
                                        @foreach($webinar->images as $image)
                                        <div class="col-md-4">
                                            <img src="{{$image}}" alt="image" height="200px" width="200px">
                                        </div>
                                        @endforeach
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div id="instructor" class="tab-pane fade">
                              <div class="cd-course-instructor yl-headline pera-content clearfix">
                                 <h3 class="c-overview-title">Webinar Author</h3>
                                 <div class="cd-course-instructor-img-text clearfix">
                                    <div class="cd-course-instructor-img float-left">
                                       <img src="@if($webinar->owner->photo===NULL) {{asset("assets/users/photo/default.png")}} @else {{asset("assets/users/photo/".$webinar->owner->photo)}} @endif" alt="">
                                    </div>
                                    <div class="cd-course-instructor-text">
                                       <h3><a href="{{route("user.view",[$webinar->owner->id,md5($webinar->owner->name)])}}">{{$webinar->owner->name}}</a></h3>
                                       <div class="cd-ins-course-student">
                                          <span><i class="fas fa-list-ul"></i> {{$webinar->owner->webinars->count()}} Webinars</span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="cd-ins-details">
                                    {!!$webinar->owner->description!!}
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
                        <img src="{{asset("assets/webinars/thumbnail/".$webinar->thumbnail)}}" alt="">
                        <a class="video_box text-center" href="#"><i class="fas fa-play"></i></a>
                     </div>
                  </div>
                  <div class="course-widget-wrap">
                     <div class="cd-course-table-widget">
                        <div class="cd-course-table-list">
                           <div class="course-table-item clearfix">
                              <span class="cd-table-title float-left"><i class="fas fa-clock"></i> Last Updated : </span>
                              <span class="cd-table-valur float-right">{{\Carbon\Carbon::parse($webinar->updated_at)->diffForHumans()}}</span>
                           </div>
                           <div class="course-table-item clearfix">
                              <span class="cd-table-title float-left"><i class="fas fa-users"></i> Subscribers  : </span>
                              <span class="cd-table-valur float-right">{{$webinar->enrolled_users->count()}}</span>
                           </div>
                           <div class="course-table-item clearfix">
                              <span class="cd-table-title float-left"><i class="material-icons text-muted icon--left">schedule</i> Schedule  : </span>
                              <span class="cd-table-valur float-right">{{\Carbon\Carbon::parse(strtotime($webinar->date." ".$webinar->time))->diffForHumans()}}</span>
                           </div>
                           <div class="course-table-item clearfix">
                              <span class="cd-table-title float-left"><i class="material-icons text-muted icon--left">category</i> Category  : </span>
                              <span class="cd-table-valur float-right">{{$webinar->category->name}}</span>
                           </div>
                           <div class="course-table-item clearfix">
                              <span class="cd-table-title float-left">Time Left  : </span>
                              <span class="cd-table-valur float-right"><div id="timer"></div></span>
                           </div>
                           <div class="course-table-item clearfix">
                              <span class="cd-table-title float-left">Duration  : </span>
                              <span class="cd-table-valur float-right">{{$webinar->duration}}</span>
                           </div>
                        </div>
                        <div class="cd-course-price clearfix">
                           <span>
                              Price: 
                              @if($discount>0)
                              {!!$webinar->price==0?"FREE":"<s><small>".$webinar->price."</small></s> ".($webinar->price-$discount)." INR"!!}
                              @else
                              {{$webinar->price==0?"FREE":$webinar->price." INR"}}
                              @endif
                           </span>
                           @auth
                            @if($dur->format('u')<=$now->format('u'))
                                @if(Auth::user()->enrolled_webinars->where("webinar_id",$webinar->id)->first()!==NULL)
                                    @if(Auth::user()->enrolled_webinars->where("webinar_id",$webinar->id)->first()->form_response===NULL)
                                        <a href="{{route("webinars.subscribe.fill-form",$webinar->id)}}">Fill Form</a>
                                    @else
                                        <a href="#!">Subscribed</a>
                                    @endif
                                @else
                                    <a href="{{route("webinars.subscribe.add",$webinar->id)}}">Subscribe Now</a>
                                @endif
                            @else
                                @if(Auth::user()->enrolled_webinars->where("webinar_id",$webinar->id)->first()!==NULL)
                                    @if(Auth::user()->enrolled_webinars->where("webinar_id",$webinar->id)->first()->form_response===NULL)
                                        <a href="{{route("webinars.subscribe.fill-form",$webinar->id)}}">Fill Form</a>
                                    @else
                                        <a href="pricing.html">Join Now</a>
                                    @endif
                                @else
                                    <a href="#!">Expired</a>
                                @endif
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
<script>
    var countDownDate = new Date("{{$webinar->date." ".$webinar->time}}").getTime();
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
        document.getElementById("timer").innerHTML = "EXPIRED";
      }
    }, 1000);
</script>
@endsection