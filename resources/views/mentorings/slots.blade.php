<?php
   $date = new DateTime($mentoring->created_at);
   $now = new DateTime("NOW");
   if($date->format("Y-m-d")===$now->format("Y-m-d")){
       $now = $now->add(new DateInterval("P1D"));
   }
   $max = $date->add(new DateInterval("P".$mentoring->availability."D"))
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
            <div class="col-lg-12">
               <div class="">
                   <form action="{{route("mentorings.subscribe.add",$mentoring->id)}}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="date">Select a date slot</label>
                            <input onchange="document.getElementById('time').style.display='block'" type="date" name="date" min="{{$now->format("Y-m-d")}}" max="{{$max->format("Y-m-d")}}" class="form-control">
                        </div>
                        <div id="time" style="display:none">
                           <div class="form-group mb-3">
                               <label for="time">Select a time slot</label>
                               <input type="time" list="times" name="time" class="form-control">
                               <datalist id="times">
                                  @foreach(json_decode($mentoring->times) as $time)
                                  <option value="{{$time}}">{{$time}}</option>
                                  @endforeach
                               </datalist>
                           </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Subscribe</button>
                   </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection