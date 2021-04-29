<?php
    $ratings = 0;
    $uratings = 0;
    $ukey = NULL;
    $ufeedback = NULL;
    if($program->feedback === NULL){
        $ratings = 0;
        $uratings = 0;
    }
    else{
        $totalr = count($program->feedback);
        foreach ($program->feedback as $key => $r) {
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
            <form action="{{route("programs.subscribe.feedback",$program->id)}}" method="post">
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
</div>
@endsection
@section('scripts')
<script src="{{asset("assets/rating/rating.js")}}"></script>
<script>
    window.onload = () => {
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