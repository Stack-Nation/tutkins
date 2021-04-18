@extends('layouts.sidebar')
@section("name","Instructor")
@section('items')
<li class="sidebar-menu-item @if(Request::route()->getName()==="instructor.dashboard") active @endif">
    <a class="sidebar-menu-button" href="{{route("instructor.dashboard")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">dashboard</span>
        <span class="sidebar-menu-text">Dashboard</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="instructor.profile") active @endif">
    <a class="sidebar-menu-button" href="{{route("instructor.profile")}}">
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
<li class="sidebar-menu-item @if(Request::route()->getName()==="instructor.courses") active @endif">
    <a class="sidebar-menu-button" href="{{route("instructor.courses")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">ondemand_video</span>
        <span class="sidebar-menu-text">Your Courses</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="user.groups") active @endif">
    <a class="sidebar-menu-button" href="{{route("user.groups")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">group</span>
        <span class="sidebar-menu-text">Your Groups</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="user.groups.member") active @endif">
    <a class="sidebar-menu-button" href="{{route("user.groups.member")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">group</span>
        <span class="sidebar-menu-text">Manage Groups</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="user.chats") active @endif">
    <a class="sidebar-menu-button" href="{{route("user.chats")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">comment</span>
        <span class="sidebar-menu-text">Messages</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="instructor.classes") active @endif">
    <a class="sidebar-menu-button" href="{{route("instructor.classes")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">class</span>
        <span class="sidebar-menu-text">Live Classes</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="instructor.exams") active @endif">
    <a class="sidebar-menu-button" href="{{route("instructor.exams")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">book</span>
        <span class="sidebar-menu-text">Exam Management</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="instructor.tests") active @endif">
    <a class="sidebar-menu-button" href="{{route("instructor.tests")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">create</span>
        <span class="sidebar-menu-text">Tests Management</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="instructor.webinars") active @endif">
    <a class="sidebar-menu-button" href="{{route("instructor.webinars")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">web</span>
        <span class="sidebar-menu-text">Webinars</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="instructor.mentorings") active @endif">
    <a class="sidebar-menu-button" href="{{route("instructor.mentorings")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">school</span>
        <span class="sidebar-menu-text">Mentoring Programs</span>
    </a>
</li>
<li class="sidebar-menu-item @if(Request::route()->getName()==="instructor.learnings") active @endif">
    <a class="sidebar-menu-button" href="{{route("instructor.learnings")}}">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">school</span>
        <span class="sidebar-menu-text">Learning Paths</span>
    </a>
</li>
@endsection