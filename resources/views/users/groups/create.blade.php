@extends('layouts.authApp')
@section("title","Create Group")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Groups</h1>
    
    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Create a new group</div>
        </div>
        <form action="{{route("user.groups.create")}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label" for="name">Name:</label>
                <input id="name" type="text" class="form-control" name="name" placeholder="Group name ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="description">Description:</label>
                <textarea name="description" id="description"></textarea>
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
                <label class="form-label" for="photo">Photo:</label>
                <input id="photo" type="file" class="form-control" name="photo">
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
    .create( document.querySelector( '#description' ) )
    .catch( error => {
        console.error( error );
    });
</script>
@endsection