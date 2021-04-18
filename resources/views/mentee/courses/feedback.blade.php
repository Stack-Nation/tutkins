<?php
    $content = json_decode(json_encode($course->content),true);
    $ratings = 0;
    $uratings = 0;
    $ukey = NULL;
    $ufeedback = NULL;
    if($course->ratings === NULL){
        $ratings = 0;
        $uratings = 0;
    }
    else{
        $totalr = count($course->ratings);
        foreach ($course->ratings as $key => $r) {
            $ratings = $ratings + (int)$r->stars;
            if($r->user_id === Auth::user()->id){
                $uratings = (int)$r->stars;
                $ufeedback = $r->feedback;
                $ukey = $key;
            }
        }
        $ratings = $ratings / $totalr;
    }
?>
@extends('layouts.courseApp')
@section("title",$course->title)
@section('content')
<div class="navbar navbar-light border-0 navbar-expand">
    <div class="container page__container">
        <div class="media flex-nowrap">
            <div class="media-left mr-16pt">
                <a href="{{route("courses.view",[$course->id,md5($course->title)])}}"><img src="{{asset("assets/courses/icon/".$course->icon)}}"
                         width="40"
                         alt="{{$course->title}}"
                         class="rounded"></a>
            </div>
            <div class="media-body">
                <a href="{{route("courses.view",[$course->id,md5($course->title)])}}"
                   class="card-title text-body mb-0">{{$course->title}}</a>
                <p class="lh-1 d-flex align-items-center mb-0">
                    <span class="text-50 small font-weight-bold mr-8pt">{{$course->instructor->name}}</span>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="bg-primary pb-lg-64pt py-32pt">
    <div class="container page__container">
        <form action="{{route("mentee.courses.feedback",[$course->id,md5($course->title)])}}" method="post">
            @csrf
            <div class="rating rating-24 mb-3">
                <div id="uratings" style="font-size:1.3rem" data-rating-value="{{$uratings}}"></div>
            </div>
            <input type="hidden" name="stars" id="urinp" value="{{$uratings}}">
            <input type="hidden" name="key" value="{{$ukey}}">
            <textarea name="feedback" id="feedback" placeholder="Enter your feedback">{{$ufeedback}}</textarea>
            <button class="btn btn-info mt-3">Submit</button>
        </form>
    </div>
</div>
<div class="navbar navbar-expand-sm navbar-light bg-white border-bottom-2 navbar-list p-0 m-0 align-items-center">
    <div class="container page__container">
        <ul class="nav navbar-nav flex align-items-sm-center">
            <li class="nav-item navbar-list__item">
                <div class="media align-items-center">
                    <span class="media-left mr-16pt">
                        <img src="@if($course->instructor->photo===NULL) {{asset("assets/users/photo/default.png")}} @else {{asset("assets/users/photo/".$course->instructor->photo)}} @endif"
                             width="40"
                             alt="avatar"
                             class="rounded-circle">
                    </span>
                    <div class="media-body">
                        <a class="card-title m-0"
                           href="teacher-profile.html">{{$course->instructor->name}}</a>
                        <p class="text-50 lh-1 mb-0">Instructor</p>
                    </div>
                </div>
            </li>
            <li class="nav-item navbar-list__item">
                <i class="material-icons text-muted icon--left">assessment</i>
                {{$course->level}}
            </li>
            <li class="nav-item ml-sm-auto text-sm-center flex-column navbar-list__item">
                <div class="rating rating-24">
                    <div id="ratings" data-rating-value="{{$ratings}}"></div>
                </div>
                <p class="lh-1 mb-0"><small class="text-muted">{{$course->ratings===NULL ? 0: count($course->ratings)}} ratings</small></p>
            </li>
        </ul>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset("assets/rating/rating.js")}}"></script>
<script>
    window.onload = () => { 
        const stars = $("#ratings").data("rating-value");
        $("#ratings").rating({
            readonly:true,
            value:stars
        });
        const ustars = $("#uratings").data("rating-value");
        $("#uratings").rating({
            value:ustars,
            "click":function (e) {
                $("#urinp").val(e.stars)
            }
        });
    }
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create( document.querySelector( '#feedback' ) )
    .catch( error => {
        console.error( error );
    });
</script>
@endsection