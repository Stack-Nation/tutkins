@extends('layouts.sidebar')
@section("name","Admin")
@section('items')   
<li class="sidebar-menu-item @if(Request::route()->getName()==="admin.dashboard") active @endif">
    <a class="sidebar-menu-button" href="{{route("admin.dashboard")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">dashboard</span>
        <span class="sidebar-menu-text">Dashboard</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="admin.apis") active @endif">
    <a class="sidebar-menu-button" href="{{route("admin.apis")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">flash_on</span>
        <span class="sidebar-menu-text">APIs</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="admin.users") active @endif">
    <a class="sidebar-menu-button" href="{{route("admin.users")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">person</span>
        <span class="sidebar-menu-text">Users</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="admin.managers") active @endif">
    <a class="sidebar-menu-button" href="{{route("admin.managers")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">person</span>
        <span class="sidebar-menu-text">Managers</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="admin.categories") active @endif">
    <a class="sidebar-menu-button" href="{{route("admin.categories")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">category</span>
        <span class="sidebar-menu-text">Categories</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="user.groups.member") active @endif">
    <a class="sidebar-menu-button" href="{{route("user.groups.member")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">group</span>
        <span class="sidebar-menu-text">Groups</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="user.groups") active @endif">
    <a class="sidebar-menu-button" href="{{route("user.groups")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">group</span>
        <span class="sidebar-menu-text">Your Groups</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="admin.courses") active @endif">
    <a class="sidebar-menu-button" href="{{route("admin.courses")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">ondemand_video</span>
        <span class="sidebar-menu-text">Courses</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="admin.webinars") active @endif">
    <a class="sidebar-menu-button" href="{{route("admin.webinars")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">web</span>
        <span class="sidebar-menu-text">Webinars</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="admin.mentorings") active @endif">
    <a class="sidebar-menu-button" href="{{route("admin.mentorings")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">school</span>
        <span class="sidebar-menu-text">Mentoring Programs</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="admin.classes") active @endif">
    <a class="sidebar-menu-button" href="{{route("admin.classes")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">class</span>
        <span class="sidebar-menu-text">Live Classes</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="admin.tests") active @endif">
    <a class="sidebar-menu-button" href="{{route("admin.tests")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">create</span>
        <span class="sidebar-menu-text">Tests Management</span>
    </a>
</li>
@endsection