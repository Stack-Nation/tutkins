@extends('layouts.authApp')
@section("title","Live Class")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Class</h1>
    
    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">{{$class->title}}</div>
        </div>
        @if($class->meeting_site === "meet")
        <div id="meet">
            <iframe is="x-frame-bypass" src="" frameborder="0"></iframe>
        </div>
        @endif
    </div>
</div>
@endsection