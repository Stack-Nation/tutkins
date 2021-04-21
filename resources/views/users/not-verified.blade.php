@extends('layouts.app')
@section("title","Not Verified")
@section('content')
<div class="row">
    <div class="col-12">
        <p class="text-dark">Your account is still pending approval from our team. Please setup your profile while we approve your account.</p>
        @if(Auth::user()->role==="Trainer")
        <a href="{{route("trainer.profile")}}" class="text-info">Click here to setup your profile</a>
        @else
        <a href="{{route("organiser.profile")}}" class="text-info">Click here to setup your profile</a>
        @endif
    </div>
</div>
@endsection