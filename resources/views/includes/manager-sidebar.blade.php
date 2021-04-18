@extends('layouts.sidebar')
@section("name","Manager")
@section('items')   
<li class="sidebar-menu-item @if(Request::route()->getName()==="manager.dashboard") active @endif">
    <a class="sidebar-menu-button" href="{{route("manager.dashboard")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">dashboard</span>
        <span class="sidebar-menu-text">Dashboard</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="manager.users") active @endif">
    <a class="sidebar-menu-button" href="{{route("manager.users")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">person</span>
        <span class="sidebar-menu-text">Users</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="manager.categories") active @endif">
    <a class="sidebar-menu-button" href="{{route("manager.categories")}}">
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
<li class="sidebar-menu-item @if(Request::route()->getName()==="manager.courses") active @endif">
    <a class="sidebar-menu-button" href="{{route("manager.courses")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">ondemand_video</span>
        <span class="sidebar-menu-text">Courses</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="manager.webinars") active @endif">
    <a class="sidebar-menu-button" href="{{route("manager.webinars")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">web</span>
        <span class="sidebar-menu-text">Webinars</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="manager.mentorings") active @endif">
    <a class="sidebar-menu-button" href="{{route("manager.mentorings")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">school</span>
        <span class="sidebar-menu-text">Mentoring Programs</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="manager.classes") active @endif">
    <a class="sidebar-menu-button" href="{{route("manager.classes")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">class</span>
        <span class="sidebar-menu-text">Live Classes</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="manager.tests") active @endif">
    <a class="sidebar-menu-button" href="{{route("manager.tests")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">create</span>
        <span class="sidebar-menu-text">Tests Management</span>
    </a>
</li>
<script>
    var html=document.getElementsByTagName("title")[0].innerHTML;
    html = html.replace(/Admin/g,"Manager");
    document.getElementsByTagName("title")[0].innerHTML=html;
</script>
@endsection