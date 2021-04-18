@extends('layouts.authApp')
@section("title","Edit Landing")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Course</h1>
    

    <div class="container page__container page-section">
        @include("includes.instructor-course-menu")
        <div class="page-separator">
            <div class="page-separator__text">Edit Course Landing</div>
        </div>
        <form action="{{route("instructor.courses.edit-land",$course->id)}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label" for="title">Title:</label>
                <input id="title" type="text" class="form-control" value="{{$course->title}}" name="title" placeholder="Course title ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="sub_title">Sub Title:</label>
                <input id="sub_title" type="text" class="form-control" value="{{$course->sub_title}}" name="sub_title" placeholder="Course sub title ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="price">Price:</label>
                <input id="price" type="number" class="form-control" value="{{$course->price}}" name="price" placeholder="Course price ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="description">Description:</label>
                <textarea name="description" id="description">{{$course->description}}</textarea>
            </div>
            <div class="page-separator">
                <div class="page-separator__text">Additional information</div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <div class="form-group">
                        <label class="form-label" for="language">Language:</label>
                        <select name="language" id="language" class="custom-select">
                            <option value="">Select a language</option>
                            @foreach ($langs as $lang)
                                <option value="{{$lang->short}}" @if($course->language === $lang->short) selected @endif>{{$lang->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12">
                    <div class="form-group">
                        <label class="form-label" for="category">Category:</label>
                        <select name="category" id="category" class="custom-select">
                            <option value="">Select a category</option>
                            @foreach ($cats as $cat)
                                <option value="{{$cat->id}}" @if($course->cid === $cat->id) selected @endif>{{$cat->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12">
                    <div class="form-group">
                        <label class="form-label" for="level">Level:</label>
                        <select name="level" id="level" class="custom-select">
                            <option value="">Select a level</option>
                            <option value="All Levels" @if($course->level==="All Levels") selected @endif>All Levels</option>
                            <option value="Beginner Level" @if($course->level==="Beginner Level") selected @endif>Beginner Level</option>
                            <option value="Intermediate Level" @if($course->level==="Intermediate Level") selected @endif>Intermediate Level</option>
                            <option value="Expert Level" @if($course->level==="Expert Level") selected @endif>Expert Level</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label class="form-label" for="icon">Icon:</label>
                        <input id="icon" type="file" accept=".jpeg,.png,.jpg" class="form-control" name="icon">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    @if ($course->icon===NULL)
                        <p class="mt-4">No icon found</p>
                    @else
                        <img src="{{asset("assets/courses/icon/".$course->icon)}}" height="100px" width="100px" alt="Icon">
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label class="form-label" for="image">Image:</label>
                        <input id="image" type="file" accept=".jpeg,.png,.jpg" class="form-control" name="image">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    @if ($course->image===NULL)
                        <p class="mt-4">No image found</p>
                    @else
                        <img src="{{asset("assets/courses/image/".$course->image)}}" height="100px" width="100px" alt="Image">
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="form-group">
                        <label class="form-label" for="video">Video:</label>
                        <input id="video" type="file" accept=".mp4" class="form-control" name="video">
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    @if ($course->video===NULL)
                        <p class="mt-4">No video found</p>
                    @else
                        <video src="{{asset("assets/courses/video/".$course->video)}}" height="200px" width="200px" controls></video>
                    @endif
                </div>
            </div>
            <button class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create( document.querySelector( '#description' ) )
    .catch( error => {
        console.error( error );
    });
</script>
@endsection