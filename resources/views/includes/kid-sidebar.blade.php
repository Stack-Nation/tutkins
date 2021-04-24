@extends('layouts.sidebar')
@section('items')
<li class="@if(Request::route()->getName()==="kid.dashboard") active @endif">
    <a class="has-arrow" href="{{route("kid.dashboard")}}" aria-expanded="false">
        <i class="mdi mdi-view-dashboard"></i> <span class="nav-text">Dashboard</span>
    </a>
</li>
<li class="@if(Request::route()->getName()==="kid.profile") active @endif">
    <a class="has-arrow" href="{{route("kid.profile")}}" aria-expanded="false">
        <i class="mdi mdi-menu"></i> <span class="nav-text">Profile</span>
    </a>
</li>
<li class="@if(Request::route()->getName()==="kid.programs") active @endif">
    <a class="has-arrow" href="{{route("kid.programs")}}" aria-expanded="false">
        <i class="mdi mdi-clipboard"></i> <span class="nav-text">Enrolled Programs</span>
    </a>
</li>
<li class="@if(Request::route()->getName()==="kid.events") active @endif">
    <a class="has-arrow" href="{{route("kid.events")}}" aria-expanded="false">
        <i class="mdi mdi-clipboard"></i> <span class="nav-text">Enrolled Events</span>
    </a>
</li>
@endsection