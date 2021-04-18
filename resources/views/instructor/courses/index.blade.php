@extends('layouts.authApp')
@section("title","Your Courses")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Courses</h1>
    

    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">{{$type}} Courses</div>
        </div>
        <select name="role" class="custom-select mb-3" id="role" onchange="getType(this);">
            <option value="All" @if($type==="All") selected @endif>All Courses</option>
            <option value="Pending" @if($type==="Pending") selected @endif>Pending Courses</option>
            <option value="Draft" @if($type==="Draft") selected @endif>Draft Courses</option>
            <option value="Published" @if($type==="Published") selected @endif>Published Courses</option>
        </select>

        <div class="card dashboard-area-tabs p-relative o-hidden mb-lg-32pt">
            <div class="card-header">
                <a href="{{route("instructor.courses.create")}}" class="btn btn-primary">Create new course</a>
            </div>
            <div class="table-responsive">
                @if($courses->count()===0)
                <p>No course found.</p>
                @else
                <div class="list-group">
                    @foreach ($courses as $course)
                        <a href="{{route("instructor.courses.edit-land",$course->id)}}" class="list-group-item list-group-item-action">
                          <div class="d-flex justify-content-between" style="width:100%">
                            <h5 class="mb-1">{{$course->title}}</h5>
                            <small>{{\Carbon\Carbon::parse($course->created_at)->diffForHumans()}}</small>
                          </div>
                          <p class="mb-1">{{$course->sub_title}}</p>
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
@section('scripts')
<script>
    function getType(obj){
        const val = $(obj).val();
        if(val==="All"){
            location.href = "{{route('instructor.courses')}}"
        }
        else{
            location.href = `{{route('instructor.courses')}}/${val}`
        }
    }
</script>
@endsection