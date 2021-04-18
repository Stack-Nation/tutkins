@extends('layouts.authApp')
@section("title","Create Test")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Exam</h1>
    
    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Create a new test</div>
        </div>
        <form action="{{route("instructor.tests.create")}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label" for="title">Title:</label>
                <input id="title" type="text" class="form-control" name="title" placeholder="Test title ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="description">Description:</label>
                <textarea name="description" id="description"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label" for="image">Image:</label>
                <input id="image" type="file" class="form-control" name="image">
            </div>
            @if($categories->count()===0)
            <p>Please create a category to proceed. <a href="{{route("instructor.exams.categories.create")}}">Click here</a> to create a new category</p>
            @else
            <div class="form-group">
                <label class="form-label" for="category">Category:</label>
                <select name="category" class="custom-select" id="category">
                    <option value="">Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            @endif
            @if($subjects->count()===0)
            <p>Please create a subject to proceed. <a href="{{route("instructor.exams.subject.create")}}">Click here</a> to create a new subject</p>
            @else
            <div class="form-group">
                <label class="form-label" for="subject">Subject:</label>
                <select name="subject" class="custom-select" id="subject">
                    <option value="">Select a subject</option>
                    @foreach ($subjects as $subject)
                        <option value="{{$subject->id}}">{{$subject->title}}</option>
                    @endforeach
                </select>
            </div>
            @endif
            @if($questions->count()===0)
            <p>Please create a question to proceed. <a href="{{route("instructor.exams.questions.create")}}">Click here</a> to create a new question</p>
            @else
            <div class="form-group">
                <label class="form-label" for="question">Select question(hold <code>ctrl</code> key to select multiple):</label>
                <select name="question[]" class="custom-select" multiple id="question">
                    @foreach ($questions as $question)
                        <option value="{{$question->id}}">{{$question->title}}</option>
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