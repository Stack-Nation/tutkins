@extends('layouts.sidebar')
@section('items')
<li class="@if(Request::route()->getName()==="manager.dashboard") active @endif">
    <a class="has-arrow" href="{{route("manager.dashboard")}}" aria-expanded="false">
        <i class="mdi mdi-view-dashboard"></i> <span class="nav-text">Dashboard</span>
    </a>
</li>
<li class="@if(Request::route()->getName()==="manager.users") active @endif">
    <a class="has-arrow" href="{{route("manager.users")}}" aria-expanded="false">
        <i class="mdi mdi-human"></i> <span class="nav-text">Users</span>
    </a>
</li>
<li class="@if(Request::route()->getName()==="manager.users.pending") active @endif">
    <a class="has-arrow" href="{{route("manager.users.pending")}}" aria-expanded="false">
        <i class="mdi mdi-human"></i> <span class="nav-text">Pending Users</span>
    </a>
</li>
<li class="@if(Request::route()->getName()==="manager.categories") active @endif">
    <a class="has-arrow" href="{{route("manager.categories")}}" aria-expanded="false">
        <i class="mdi mdi-filter"></i> <span class="nav-text">Categories</span>
    </a>
</li>
<li class="@if(Request::route()->getName()==="manager.programs") active @endif">
    <a class="has-arrow" href="{{route("manager.programs")}}" aria-expanded="false">
        <i class="mdi mdi-clipboard"></i> <span class="nav-text">Programs</span>
    </a>
</li>
<li class="@if(Request::route()->getName()==="manager.events") active @endif">
    <a class="has-arrow" href="{{route("manager.events")}}" aria-expanded="false">
        <i class="mdi mdi-clipboard"></i> <span class="nav-text">Events</span>
    </a>
</li>
@endsection