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
@endsection