@extends('layouts.authApp')
@section("title","Create Certificate")
@section('head')
<style>
    .points{
        position:  relative;
        padding:0;
    }
</style>
@endsection
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-0">Learning Path</h1>
    
    <div class="container page__container page-section">

        <div class="page-separator">
            <div class="page-separator__text">Create a certificate for {{$learning->title}}</div>
        </div>
        <div class="form-group">
            <input type="file" class="form-control" name="certificate" accept=".jpg,.jpeg,.png" onchange="changeImage(this)">
            <div id="certificate" style="display: none;">
                <div id="cert-edit" style="width:100%;height:600px;background-size: 100%"></div>
                <div id="points">
                    <ul class="list-group list-group-horizontal">
                        <li draggable="true" class="list-group-item points mr-2" id="name" ondragstart="drag_start(event);">Receiver Name</li>
                        <li draggable="true" class="list-group-item points mr-2" id="path_name" ondragstart="drag_start(event);">Learning Path Name</li>
                        <li draggable="true" class="list-group-item points mr-2" id="date" ondragstart="drag_start(event);">Receiving Date</li>
                    </ul>
                </div>
            </div>
        </div>
        <form action="{{route("instructor.learnings.certificate.create",$learning->id)}}" onsubmit="fillContent(event);" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="image" id="image">
            <input type="hidden" name="name" id="inpname">
            <input type="hidden" name="path_name" id="inppathname">
            <input type="hidden" name="date" id="inpdate">
            <button class="btn btn-primary">Save</button>
        </form>

    </div>
</div>
@endsection
@section('scripts')
<script>
    function changeImage(input) {
        var reader;

        if (input.files && input.files[0]) {
            reader = new FileReader();
            reader.onload = function(e) {
                $("#cert-edit").css("background-image",`url("${e.target.result}")`);
                $("#image").val(e.target.result);
                $("#certificate").css("display","block");
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    var d = null;
    function drag_start(event) {
        d = event.target;
        var style = window.getComputedStyle(event.target, null);
        event.dataTransfer.setData("text/plain",
        (parseInt(style.getPropertyValue("left"),10) - event.clientX) + ',' + (parseInt(style.getPropertyValue("top"),10) - event.clientY));
    } 
    function drag_over(event) { 
        event.preventDefault(); 
        return false; 
    } 
    function drop(event) { 
        var offset = event.dataTransfer.getData("text/plain").split(',');
        d.style.left = (event.clientX + parseInt(offset[0],10)) + 'px';
        d.style.top = (event.clientY + parseInt(offset[1],10)) + 'px';
        event.preventDefault();
        return false;
    } 
    function dragend(event){
        d = null;
    }
    document.getElementById("cert-edit").addEventListener('dragover',drag_over,false); 
    document.getElementById("cert-edit").addEventListener('drop',drop,false); 
    document.getElementById("cert-edit").addEventListener('dragend',dragend,false); 

    function fillContent(e){
        const name = {
            "x":$("#name").position().left,
            "y":$("#name").position().top,
        }
        const path = {
            "x":$("#path_name").position().left,
            "y":$("#path_name").position().top,
        }
        const date = {
            "x":$("#date").position().left,
            "y":$("#date").position().top,
        }
        $("#inpname").val(JSON.stringify(name));
        $("#inppathname").val(JSON.stringify(path));
        $("#inpdate").val(JSON.stringify(date));
    }
</script>
@endsection