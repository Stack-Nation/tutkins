@extends('layouts.courseApp')
@section("title","Create Post")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Forum</h1>
    
    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Create a new post</div>
        </div>
        <form action="{{route("posts.create",[$forum->id,md5($forum->name)])}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label" for="title">Title:</label>
                <input id="title" type="text" class="form-control" name="title" placeholder="Post title ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="body">Body:</label>
                <textarea name="body" id="body"></textarea>
            </div>
            <button class="btn btn-primary">Create</button>
        </form>

    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create( document.querySelector( '#body' ) )
    .catch( error => {
        console.error( error );
    });
</script>
@endsection