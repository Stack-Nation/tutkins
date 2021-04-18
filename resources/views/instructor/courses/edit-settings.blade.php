@extends('layouts.authApp')
@section("title","Edit Landing")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Course</h1>
    

    <div class="container page__container page-section">
        @include("includes.instructor-course-menu")
        <div class="page-separator">
            <div class="page-separator__text">Edit Course Settings</div>
        </div>
        @if($course->review === 0)
        <form action="{{route("instructor.courses.edit-settings.review",$course->id)}}" method="post">
            @csrf
            <button class="btn btn-info mt-3">Submit for review</button> <h5>A staff member will review your course and will approved it within 24-48 hours.</h5>
        </form>
        @endif
        @if($course->approved === 1)
        <form action="{{route("instructor.courses.edit-settings.publish",$course->id)}}" method="post">
            @csrf
            <button class="btn @if($course->published===1) btn-outline-danger @else btn-primary @endif mt-3">@if($course->published===1) Unpublish @else Publish @endif</button>
        </form>
        @endif
        <form action="{{route("instructor.courses.edit-settings.delete",$course->id)}}" method="post">
            @csrf
            <button class="btn btn-danger mt-3">Delete</button>
            <h5>This will not delete the course for the users who have enrolled to it.</h5>
        </form>
    </div>
</div>
@endsection