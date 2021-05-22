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
<li class="@if(Request::route()->getName()==="admin.users.pending") active @endif">
    <a class="has-arrow" href="{{route("admin.users.pending")}}" aria-expanded="false">
        <i class="mdi mdi-human"></i> <span class="nav-text">Pending Users</span>
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
<li class="@if(Request::route()->getName()==="admin.programs") active @endif">
    <a class="has-arrow" href="{{route("admin.programs")}}" aria-expanded="false">
        <i class="mdi mdi-clipboard"></i> <span class="nav-text">Programs</span>
    </a>
</li>
<li class="@if(Request::route()->getName()==="admin.events") active @endif">
    <a class="has-arrow" href="{{route("admin.events")}}" aria-expanded="false">
        <i class="mdi mdi-clipboard"></i> <span class="nav-text">Events</span>
    </a>
</li>
<li class="@if(Request::route()->getName()==="admin.withdrawals.pending") active @endif">
    <a class="has-arrow" href="{{route("admin.withdrawals.pending")}}" aria-expanded="false">
        <i class="mdi mdi-clipboard"></i> <span class="nav-text">Pending Withdrawals</span>
    </a>
</li>
<li class="@if(Request::route()->getName()==="admin.withdrawals.approved") active @endif">
    <a class="has-arrow" href="{{route("admin.withdrawals.approved")}}" aria-expanded="false">
        <i class="mdi mdi-clipboard"></i> <span class="nav-text">Approved Withdrawals</span>
    </a>
</li>
@endsection