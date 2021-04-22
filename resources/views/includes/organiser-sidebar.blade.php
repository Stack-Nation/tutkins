@extends('layouts.sidebar')
@section('items')
<li class="@if(Request::route()->getName()==="organiser.dashboard") active @endif">
    <a class="has-arrow" href="{{route("organiser.dashboard")}}" aria-expanded="false">
        <i class="mdi mdi-view-dashboard"></i> <span class="nav-text">Dashboard</span>
    </a>
</li>
<li class="@if(Request::route()->getName()==="organiser.profile") active @endif">
    <a class="has-arrow" href="{{route("organiser.profile")}}" aria-expanded="false">
        <i class="mdi mdi-menu"></i> <span class="nav-text">Profile</span>
    </a>
</li>
<li class="@if(Request::route()->getName()==="organiser.events") active @endif">
    <a class="has-arrow" href="{{route("organiser.events")}}" aria-expanded="false">
        <i class="mdi mdi-clipboard"></i> <span class="nav-text">Events</span>
    </a>
</li>
@endsection