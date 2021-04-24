@extends('layouts.sidebar')
@section('items')
<li class="@if(Request::route()->getName()==="kid.dashboard") active @endif">
    <a class="has-arrow" href="{{route("kid.dashboard")}}" aria-expanded="false">
        <i class="mdi mdi-view-dashboard"></i> <span class="nav-text">Dashboard</span>
    </a>
</li>
@endsection