@extends('layouts.sidebar')
@section('items')
<li class="@if(Request::route()->getName()==="trainer.dashboard") active @endif">
    <a class="has-arrow" href="{{route("trainer.dashboard")}}" aria-expanded="false">
        <i class="mdi mdi-view-dashboard"></i> <span class="nav-text">Dashboard</span>
    </a>
</li>
<li class="@if(Request::route()->getName()==="trainer.profile") active @endif">
    <a class="has-arrow" href="{{route("trainer.profile")}}" aria-expanded="false">
        <i class="mdi mdi-menu"></i> <span class="nav-text">Profile</span>
    </a>
</li>
<li class="@if(Request::route()->getName()==="trainer.programs") active @endif">
    <a class="has-arrow" href="{{route("trainer.programs")}}" aria-expanded="false">
        <i class="mdi mdi-clipboard"></i> <span class="nav-text">Programs</span>
    </a>
</li>
@if(Auth::user()->is_org==1)
<li class="@if(Request::route()->getName()==="organiser.events") active @endif">
    <a class="has-arrow" href="{{route("organiser.events")}}" aria-expanded="false">
        <i class="mdi mdi-clipboard"></i> <span class="nav-text">Events</span>
    </a>
</li>
@endif
@endsection