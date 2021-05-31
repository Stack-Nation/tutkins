@extends('layouts.authApp')
@section("title","Edit ".$program->title)
@section('head')
<link rel="stylesheet" href="{{asset("assets/main/assets/plugins/select2/css/select2.min.css")}}">
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Edit {{$program->title}}</h2>
            </div>
            <div class="card-body">
                <form action="{{route("trainer.programs.edit",$program->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 form-group mb-2">
                            <label for="title">Program title</label>
                            <input type="text" name="title" id="title" value="{{$program->title}}" class="form-control form-control-sm">
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label for="description">Program description</label>
                            <textarea name="description" id="description">{{$program->description}}</textarea>
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label for="instructions">Program instructions</label>
                            <textarea name="instructions" id="instructions">{{$program->instructions}}</textarea>
                        </div>
                        <div class="col-lg-6 col-md-12 form-group mb-2">
                            <label for="category">Program category</label>
                            <select name="category" id="category" class="custom-select custom-select-lg dropdown-groups">
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" @if($program->category_id==$category->id) selected @endif>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-12 form-group mb-2">
                            <label for="mode">Program mode</label>
                            <select name="mode" id="mode" onchange="getMode(this);" class="custom-select custom-select-lg dropdown-groups">
                                <option value="">Select a mode</option>
                                <option value="Online" @if($program->mode=="Online") selected @endif>Online</option>
                                <option value="Student's Location" @if($program->mode=="Student's Location") selected @endif>Student's Location</option>
                                <option value="Trainer's Location" @if($program->mode=="Trainer's Location") selected @endif>Trainer's Location</option>
                            </select>
                        </div>
                        <div class="col-12 form-group mb-2" id="linkD" style="display: none">
                            <label for="link">Program link</label>
                            <input type="text" name="link" id="link" value="{{$program->link}}" class="form-control form-control-sm">
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label for="duration">Program duration</label>
                            <input type="text" name="duration" value="{{$program->duration}}" id="duration" class="form-control form-control-sm">
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label for="classes">Number of classes</label>
                            <input type="number" name="classes" value="{{$program->classes}}" id="classes" class="form-control form-control-sm">
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label for="batch_size">Batch Size</label>
                            <input type="number" name="batch_size" id="batch_size" class="form-control form-control-sm">
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label for="age_group">Age Group</label>
                            <input type="text" name="age_group" id="age_group" class="form-control form-control-sm">
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label for="price">Program price</label>
                            <input type="number" name="price" value="{{$program->price}}" id="price" class="form-control form-control-sm">
                        </div>
                        <div class="col-12 form-group mb-2">
                            <label for="trial_price">Program trial price</label>
                            <input type="number" name="trial_price" value="{{$program->trial_price}}" id="trial_price" class="form-control form-control-sm">
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

    function getMode(obj){
        if($(obj).val()=="Online"){
            $("#linkD").css("display","block");
        }
        else{
            $("#linkD").css("display","none");
        }
    }
</script>
<script src="{{asset("assets/main/assets/plugins/select2/js/select2.full.min.js")}}"></script>
<script src="{{asset("assets/main/js/plugins-init/select2-init.js")}}"></script>
@endsection