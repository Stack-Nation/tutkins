@extends('layouts.authApp')
@section("title","Create Webinar")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Webinar</h1>
    
    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Create a new webinar</div>
        </div>
        <form action="{{route("instructor.webinars.create")}}" onsubmit="checkImages(event)" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label" for="title">Title:</label>
                <input id="title" type="text" class="form-control" name="title" placeholder="Webinar title ...">
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
                <label class="form-label" for="category">Category:</label>
                <select name="category" id="category" class="custom-select">
                    <option value="">Select a category</option>
                    @foreach ($cats as $cat)
                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="date">Date:</label>
                <input id="date" type="date" class="form-control" name="date">
            </div>
            <div class="form-group">
                <label class="form-label" for="time">Time:</label>
                <input id="time" type="time" class="form-control" name="time">
            </div>
            <div class="form-group">
                <label class="form-label" for="price">Price:</label>
                <input id="price" type="number" class="form-control" name="price" placeholder="Webinar price ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="discount">Discount%:</label>
                <input id="discount" type="number" class="form-control" name="discount" placeholder="Webinar discount % ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="duration">Duration:</label>
                <input id="duration" type="text" class="form-control" name="duration" placeholder="Webinar duration(ex: 1 hour) ...">
            </div>
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
    if (parseInt($fileUpload.get(0).files.length)>4){
        e.preventDefault()
        alert("You can only upload a maximum of 4 files");
        return false;
    }
    else{
        return true;
    }
}
</script>
@endsection