@extends('layouts.authApp')
@section("title","Edit ".$event->title)
@section('head')
<link rel="stylesheet" href="{{asset("assets/main/assets/plugins/select2/css/select2.min.css")}}">
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Edit {{$event->title}}</h2>
            </div>
            <div class="card-body">
                <form action="{{route("organiser.events.edit",$event->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 form-group mb-2">
                            <label for="title">Event title</label>
                            <input type="text" name="title" id="title" value="{{$event->title}}" class="form-control form-control-sm">
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label for="description">Event description</label>
                            <textarea name="description" id="description">{{$event->description}}</textarea>
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label for="instructions">Event instructions</label>
                            <textarea name="instructions" id="instructions">{{$event->instructions}}</textarea>
                        </div>
                        <div class="col-lg-6 col-md-12 form-group mb-2">
                            <label for="category">Event category</label>
                            <select name="category" id="category" class="custom-select custom-select-lg dropdown-groups">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if($event->category_id==$category->id) selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-12 form-group mb-2">
                            <label for="mode">Event mode</label>
                            <select name="mode" id="mode" onchange="getMode(this);" class="custom-select custom-select-lg dropdown-groups">
                                <option value="">Select a mode</option>
                                <option value="Online" @if($event->mode=="Online") selected @endif>Online</option>
                                <option value="Offline" @if($event->mode=="Offline") selected @endif>Offline</option>
                            </select>
                        </div>
                        <div class="col-12 form-group mb-2" id="linkD" style="display: none">
                            <label for="link">Event link</label>
                            <input type="text" name="link" id="link" value="{{$event->link}}" class="form-control form-control-sm">
                        </div>
                        <div id="addD" class="row" style="display:none">
                            <div class="col-12 form-group mb-2">
                                <label class="form-label" for="country">Country:</label>
                                <input id="country" value="{{$event->country}}" type="text" class="form-control form-control-sm" name="country">
                            </div>
                            <div class="col-12 form-group mb-2">
                                <label class="form-label" for="state">State:</label>
                                <input id="state" value="{{$event->state}}" type="text" class="form-control form-control-sm" name="state">
                            </div>
                            <div class="col-12 form-group mb-2">
                                <label class="form-label" for="city">City:</label>
                                <input id="city" value="{{$event->city}}" type="text" class="form-control form-control-sm" name="city">
                            </div>
                            <div class="col-12 form-group mb-2">
                                <label class="form-label" for="address">Address:</label>
                                <input id="address" value="{{$event->address}}" type="text" class="form-control form-control-sm" name="address">
                            </div>
                            <div class="col-12 form-group mb-2">
                                <label class="form-label" for="pin_code">Pin Code:</label>
                                <input id="pin_code" value="{{$event->pin_code}}" type="text" class="form-control form-control-sm" name="pin_code" >
                            </div>
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label for="duration">Event duration</label>
                            <input type="text" name="duration" value="{{$event->duration}}" id="duration" class="form-control form-control-sm">
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label for="days">Number of days</label>
                            <input type="number" name="days" value="{{$event->days}}" id="days" class="form-control form-control-sm">
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label for="price">Event price</label>
                            <input type="number" name="price" value="{{$event->price}}" id="price" class="form-control form-control-sm">
                        </div>
                        <div class="col-12 form-group mb-2">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
ClassicEditor
    .create( document.querySelector( '#instructions' ) )
    .catch( error => {
        console.error( error );
    });
        if($("#mode").val()=="Online"){
            $("#linkD").css("display","block");
        }
        else{
            $("#linkD").css("display","none");
        }
        if($("#mode").val()=="Offline"){
            $("#addD").css("display","flex");
        }
        else{
            $("#addD").css("display","none");
        }

    function getMode(obj){
        if($(obj).val()=="Online"){
            $("#linkD").css("display","block");
        }
        else{
            $("#linkD").css("display","none");
        }
        if($(obj).val()=="Offline"){
            $("#addD").css("display","flex");
        }
        else{
            $("#addD").css("display","none");
        }
    }
</script>
<script src="{{asset("assets/main/assets/plugins/select2/js/select2.full.min.js")}}"></script>
<script src="{{asset("assets/main/js/plugins-init/select2-init.js")}}"></script>
@endsection