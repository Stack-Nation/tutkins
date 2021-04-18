@extends('layouts.authApp')
@section("title","Create Learning Path")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Learning Path</h1>
    
    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Create a new learning path</div>
        </div>
        <form action="{{route("instructor.learnings.create")}}" onsubmit="checkImages(event)" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label" for="title">Title:</label>
                <input id="title" type="text" class="form-control" name="title" placeholder="Learning Path title ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="description">Description:</label>
                <textarea name="description" id="description"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label" for="images[]">Images:</label>
                <input id="images" type="file" accept=".png,.jpeg,.jpg" multiple class="form-control" name="images[]">
            </div>
            <div class="form-group">
                <label class="form-label" for="thumbnail">Thumbnail:</label>
                <input id="thumbnail" type="file" accept=".png,.jpeg,.jpg" class="form-control" name="thumbnail">
            </div>
            <div class="form-group">
                <label class="form-label" for="price">Price:</label>
                <input id="price" type="number" class="form-control" name="price" placeholder="Learning Path price ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="discount">Discount:</label>
                <input id="discount" type="number" class="form-control" name="discount" placeholder="Learning Path discount ...">
            </div>
            @if($courses->count()===0)
            <p>Please create a course to proceed. <a href="{{route("instructor.courses.create")}}">Click here</a> to create a new course</p>
            @else
            <div class="form-group">
                <label class="form-label" for="courses">Select course(hold <code>ctrl</code> key to select multiple):</label>
                <select name="courses[]" class="custom-select" multiple id="courses">
                    @foreach ($courses as $course)
                        <option value="{{$course->id}}">{{$course->title}}</option>
                    @endforeach
                </select>
            </div>
            @endif
            @if($tests->count()===0)
            <p>Please create a test group to proceed. <a href="{{route("instructor.tests.groups.create")}}">Click here</a> to create a new test group</p>
            @else
            <div class="form-group">
                <label class="form-label" for="tests">Select test group(hold <code>ctrl</code> key to select multiple):</label>
                <select name="tests[]" class="custom-select" multiple id="tests">
                    @foreach ($tests as $test)
                        <option value="{{$test->id}}">{{$test->title}}</option>
                    @endforeach
                </select>
            </div>
            @endif
            @if($mentorings->count()===0)
            <p>Please create a mentoring to proceed. <a href="{{route("instructor.mentorings.create")}}">Click here</a> to create a new mentoring</p>
            @else
            <div class="form-group">
                <label class="form-label" for="mentorings">Select mentoring(hold <code>ctrl</code> key to select multiple):</label>
                <select name="mentorings[]" class="custom-select" multiple id="mentorings">
                    @foreach ($mentorings as $mentoring)
                        <option value="{{$mentoring->id}}">{{$mentoring->title}}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <button class="btn btn-primary">Next</button>
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

function checkImages(e){
    var $fileUpload = $("#images");
    if (parseInt($fileUpload.get(0).files.length)>8){
        e.preventDefault()
        alert("You can only upload a maximum of 8 files");
        return false;
    }
    else{
        return true;
    }
}
</script>
@endsection