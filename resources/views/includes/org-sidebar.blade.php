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
<li class="@if(Request::route()->getName()==="organiser.programs") active @endif">
    <a class="has-arrow" href="{{route("organiser.programs")}}" aria-expanded="false">
        <i class="mdi mdi-clipboard"></i> <span class="nav-text">Programs</span>
    </a>
</li>
@endsection