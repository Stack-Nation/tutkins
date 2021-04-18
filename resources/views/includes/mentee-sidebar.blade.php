@extends('layouts.sidebar')
@section("name","Mentee")
@section('items')
<li class="sidebar-menu-item @if(Request::route()->getName()==="mentee.dashboard") active @endif">
    <a class="sidebar-menu-button" href="{{route("mentee.dashboard")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">dashboard</span>
        <span class="sidebar-menu-text">Dashboard</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="mentee.profile") active @endif">
    <a class="sidebar-menu-button" href="{{route("mentee.profile")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">perm_contact_calendar</span>
        <span class="sidebar-menu-text">Profile</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="user.resume") active @endif">
    <a class="sidebar-menu-button" href="{{route("user.resume")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">perm_contact_calendar</span>
        <span class="sidebar-menu-text">Resume</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="mentee.courses") active @endif">
    <a class="sidebar-menu-button" href="{{route("mentee.courses")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">ondemand_video</span>
        <span class="sidebar-menu-text">Enrolled Courses</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="user.groups.member") active @endif">
    <a class="sidebar-menu-button" href="{{route("user.groups.member")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">group</span>
        <span class="sidebar-menu-text">Manage Groups</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="user.groups") active @endif">
    <a class="sidebar-menu-button" href="{{route("user.groups")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">group</span>
        <span class="sidebar-menu-text">Your Groups</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="user.chats") active @endif">
    <a class="sidebar-menu-button" href="{{route("user.chats")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">comment</span>
        <span class="sidebar-menu-text">Messages</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="mentee.webinars") active @endif">
    <a class="sidebar-menu-button" href="{{route("mentee.webinars")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">web</span>
        <span class="sidebar-menu-text">Webinars</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="mentee.mentorings") active @endif">
    <a class="sidebar-menu-button" href="{{route("mentee.mentorings")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">school</span>
        <span class="sidebar-menu-text">Mentoring Programs</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="mentee.transactions") active @endif">
    <a class="sidebar-menu-button" href="{{route("mentee.transactions")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">receipt_long</span>
        <span class="sidebar-menu-text">Transactions</span>
    </a>
</li>
@endsection