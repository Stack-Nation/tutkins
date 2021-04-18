@extends('layouts.authApp')
@section("title","Create Test Group")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Exam</h1>
    
    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Create a new test group</div>
        </div>
        <form action="{{route("instructor.tests.groups.create")}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label" for="title">Title:</label>
                <input id="title" type="text" class="form-control" name="title" placeholder="Test group title ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="description">Description:</label>
                <textarea name="description" id="description"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label" for="image">Image:</label>
                <input id="image" type="file" class="form-control" name="image">
            </div>
            @if($tests->count()===0)
            <p>Please create a test to proceed. <a href="{{route("instructor.tests.create")}}">Click here</a> to create a new test</p>
            @else
            <div class="form-group">
                <label class="form-label" for="test">Select test(hold <code>ctrl</code> key to select multiple):</label>
                <select name="test[]" class="custom-select" multiple id="test">
                    @foreach ($tests as $test)
                        <option value="{{$test->id}}">{{$test->title}}</option>
                    @endforeach
                </select>
            </div>
            @endif
            <button class="btn btn-primary">Create</button>
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