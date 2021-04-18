@extends('layouts.authApp')
@section("title","Create Live Class")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Classes</h1>
    
    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Create a new live class</div>
        </div>
        <form action="{{route("instructor.classes.create")}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label" for="meeting_site">Platform:</label>
                <select name="meeting_site" id="meeting_site" onchange="setPlatform(this)" class="custom-select">
                    <option value="">Select a meeting platform</option>
                    <option value="meet">Google Meet</option>
                </select>
            </div>
            <div class="form-group" id="meet" style="display: none;">
                <label class="form-label" for="meeting_id">Meeting ID:</label>
                <input id="meeting_id" type="text" class="form-control" name="meeting_id" placeholder="Google meet meeting ID(Not link) ...">
            </div>
            <div class="form-group" id="zoom" style="display: none;">
                @if(Auth::user()->zoom_code===NULL)
                <p>You have not authorized {{config("app.name")}} to access your zoom account yet. Please <button type="button" onclick="document.getElementById('authF').submit()" class="btn btn-link">Click here to authorize(one time)</button></p>
                @else
                <label class="form-label" for="meeting_user_id">User ID:</label>
                <input id="meeting_user_id" type="text" class="form-control" name="meeting_user_id" placeholder="Zoom user id or email ...">
                @endif
            </div>
            <div class="form-group">
                <label class="form-label" for="title">Title:</label>
                <input id="title" type="text" class="form-control" name="title" placeholder="Class title ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="description">Description:</label>
                <textarea name="description" id="description"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label" for="course">Course:</label>
                <select name="course" id="course" class="custom-select">
                    <option value="">Select a course</option>
                    @foreach ($courses as $course)
                        <option value="{{$course->id}}">{{$course->title}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="thumbnail">Thumbnail:</label>
                <input id="thumbnail" type="file" class="form-control" name="thumbnail">
            </div>
            <div class="form-group">
                <label class="form-label" for="image1">Image 1:</label>
                <input id="image1" type="file" class="form-control" name="image1">
            </div>
            <div class="form-group">
                <label class="form-label" for="image2">Image 2:</label>
                <input id="image2" type="file" class="form-control" name="image2">
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
                <input id="price" type="number" class="form-control" name="price" placeholder="Class price ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="discount">Discount:</label>
                <input id="discount" type="number" class="form-control" name="discount" placeholder="Class discount ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="duration">Duration:</label>
                <input id="duration" type="text" class="form-control" name="duration" placeholder="Class duration(ex: 1 hour) ...">
            </div>
            <button class="btn btn-primary">Create</button>
        </form>

    </div>
</div>

<form action="https://zoom.us/oauth/authorize" method="post" id="authF">
    <input type="hidden" name="response_type" value="code">
    <input type="hidden" name="redirect_uri" value="{{route("user.zoom.auth")}}">
    <input type="hidden" name="client_id" value="{{\App\Models\Api::get()->first()->zoom_api_key}}">
</form>
@endsection
@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create( document.querySelector( '#description' ) )
    .catch( error => {
        console.error( error );
    });
function setPlatform(obj){
    const val = $(obj).val();
    if(val==="meet"){
        $("#meet").css("display","block");
        $("#zoom").css("display","none");
    }
    else if(val==="zoom"){
        $("#zoom").css("display","block");
        $("#meet").css("display","none");
    }
}
</script>
@endsection