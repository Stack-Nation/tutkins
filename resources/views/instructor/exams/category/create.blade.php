@extends('layouts.authApp')
@section("title","Create Category")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Exam</h1>
    
    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Create a new category</div>
        </div>
        <form action="{{route("instructor.exams.categories.create")}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label" for="name">Name:</label>
                <input id="name" type="text" class="form-control" name="name" placeholder="Category name ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="image">Image:</label>
                <input id="image" type="file" class="form-control" name="image">
            </div>
            <button class="btn btn-primary">Create</button>
        </form>

    </div>
</div>
@endsection