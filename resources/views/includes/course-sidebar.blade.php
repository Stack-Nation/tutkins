@extends('layouts.sidebar')
@section("name","Course Content")
@section('items')
<?php $i=0; ?>
@foreach($course->content as $key => $content)
<li class="sidebar-menu-item">
    <a class="sidebar-menu-button js-sidebar-collapse collapsed" data-toggle="collapse" href="#menu-{{$i}}" aria-expanded="false">
        <span class="material-icons sidebar-menu-icon sidebar-menu-icon--left">donut_large</span>
        {{$key}}
        <span class="ml-auto sidebar-menu-toggle-icon"></span>
    </a>
    <ul class="sidebar-submenu sm-indent collapse" id="menu-{{$i}}" style="">
        @foreach($content->content as $lkey => $data)
        <li class="sidebar-menu-item">
            <a class="sidebar-menu-button" href="{{route("mentee.courses.view",[$course->id,md5($course->title),$i,$lkey])}}">
                <span class="sidebar-menu-text">@if($data->type==="quiz")Quiz: @endif{{$data->lecture_title}}</span>
            </a>
        </li>
        @endforeach
    </ul>
</li>
<?php $i++; ?>
@endforeach
<li class="sidebar-menu-item">
    <a class="sidebar-menu-button" href="{{route("groups.view",[$course->group->id,md5($course->group->name)])}}">
        <span class="sidebar-menu-text">Group</span>
    </a>
</li>
<li class="sidebar-menu-item {{Request::is("posts*")?"active":""}}">
    <a class="sidebar-menu-button" href="{{route("posts.index",[$course->forum->id,md5($course->forum->name)])}}">
        <span class="sidebar-menu-text">Discussion Forum</span>
    </a>
</li>
<li class="sidebar-menu-item {{Request::is("mentee/courses/$course->id/md5($course->title)/classes")?"active":""}}">
    <a class="sidebar-menu-button" href="{{route("mentee.courses.classes",[$course->id,md5($course->title)])}}">
        <span class="sidebar-menu-text">Live Classes</span>
    </a>
</li>
<li class="sidebar-menu-item {{Request::is("mentee/courses/feedback*")?"active":""}}">
    <a class="sidebar-menu-button" href="{{route("mentee.courses.feedback",[$course->id,md5($course->title)])}}">
        <span class="sidebar-menu-text">Feedback</span>
    </a>
</li>
@endsection