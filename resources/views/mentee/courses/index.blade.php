@extends('layouts.authApp')
@section("title","Enrolled Courses")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Courses</h1>
    

    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Enrolled Courses</div>
        </div>

        <div class="card dashboard-area-tabs p-relative o-hidden mb-lg-32pt">
            <div class="table-responsive">
                @if($courses->count()===0)
                <p>No course found.</p>
                @else
                <div class="list-group">
                    @foreach ($courses as $course)
                        <a href="{{route("mentee.courses.view",[$course->course_id,md5($course->course->title),0,0])}}" class="list-group-item list-group-item-action">
                          <div class="d-flex justify-content-between" style="width:100%">
                            <h5 class="mb-1">{{$course->course->title}}</h5>
                            <small>{{\Carbon\Carbon::parse($course->created_at)->diffForHumans()}}</small>
                          </div>
                          <p class="mb-1">{{$course->course->sub_title}}</p>
                        </a>
                    @endforeach
                </div>
                @endif
            </div>

            <div class="card-footer p-8pt">

                {{$courses->links()}}

            </div>

        </div>

    </div>
</div>
@endsection