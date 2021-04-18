@extends('layouts.authApp')
@section("title","Create Course")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Courses</h1>
    
    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Create a new course</div>
        </div>
        <form action="{{route("instructor.courses.create")}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label" for="title">Title:</label>
                <input id="title" type="text" class="form-control" name="title" placeholder="Course title ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="sub_title">Sub Title:</label>
                <input id="sub_title" type="text" class="form-control" name="sub_title" placeholder="Course sub title ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="category">Category:</label>
                <select name="category" id="category" class="custom-select">
                    <option value="">Select a category</option>
                    @foreach ($cats as $cat)
                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="icon">Icon:</label>
                <input id="icon" type="file" class="form-control" name="icon">
            </div>
            <button class="btn btn-primary">Create</button>
        </form>

    </div>
</div>
@endsection