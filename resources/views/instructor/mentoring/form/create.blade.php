@extends('layouts.authApp')
@section("title","Create Questionair Form")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Mentoring Program</h1>
    
    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Create a questionair form for {{$mentoring->title}}</div>
        </div>
        <div id="form-builder"></div>
        <form action="{{route("instructor.mentorings.form.create",$mentoring->id)}}" onsubmit="fillContent(event);" method="post" enctype="multipart/form-data">
            @csrf
            <textarea hidden name="content" id="inpcontent"></textarea>
            <button class="btn btn-primary">Save</button>
        </form>

    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
<script src="{{asset("assets/formbuilder/form-builder.min.js")}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script>
ClassicEditor
    .create( document.querySelector( '#description' ) )
    .catch( error => {
        console.error( error );
    });
var fbEditor = document.getElementById('form-builder');
var formBuilder = $(fbEditor).formBuilder();
window.onload = () => {
    setTimeout(()=>{
        $($(".get-data")[0]).remove();
        $($(".save-template")[0]).remove()
    },100)
}
function fillContent(e){
    $("#inpcontent").val(JSON.stringify(formBuilder.actions.getData('json', true)));
}
</script>
@endsection