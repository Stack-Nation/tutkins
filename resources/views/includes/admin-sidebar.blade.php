@extends('layouts.sidebar')
@section('items')  
<li class="@if(Request::route()->getName()==="admin.dashboard") active @endif">
    <a class="has-arrow" href="{{route("admin.dashboard")}}" aria-expanded="false">
        <i class="mdi mdi-view-dashboard"></i> <span class="nav-text">Dashboard</span>
    </a>
</li>
<li class="@if(Request::route()->getName()==="admin.apis") active @endif">
    <a class="has-arrow" href="{{route("admin.apis")}}" aria-expanded="false">
        <i class="mdi mdi-flash-auto"></i> <span class="nav-text">APIs</span>
    </a>
</li>
<li class="@if(Request::route()->getName()==="admin.users") active @endif">
    <a class="has-arrow" href="{{route("admin.users")}}" aria-expanded="false">
        <i class="mdi mdi-human"></i> <span class="nav-text">Users</span>
    </a>
</li>
<li class="@if(Request::route()->getName()==="admin.managers") active @endif">
    <a class="has-arrow" href="{{route("admin.managers")}}" aria-expanded="false">
        <i class="mdi mdi-human"></i> <span class="nav-text">Manager</span>
    </a>
</li>
<li class="@if(Request::route()->getName()==="admin.categories") active @endif">
    <a class="has-arrow" href="{{route("admin.categories")}}" aria-expanded="false">
        <i class="mdi mdi-filter"></i> <span class="nav-text">Categories</span>
    </a>
</li>
@endsection