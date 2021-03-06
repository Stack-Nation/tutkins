@extends('layouts.app')
@section("title","Programs")
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Programs</h1>
                <hr>
                <form action="{{route("programs.search")}}" method="post">
                    @csrf
                    <div class="col-md-4 mb-2">
                        <input type="text" class="form-control" id="city" name="city" placeholder="City">
                    </div>
                    <div class="col-md-4 mb-2">
                        <input type="text" class="form-control" id="age_group" name="age_group" placeholder="Age Group">
                    </div>
                    <div class="col-md-4 mb-2">
                        <select name="category" id="category" class="custom-select">
                            <option value="">Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-success">Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container">
        @if($programs->count()===0)
        <p class="text-dark">No program found</p>
        @else
        <div class="row">
            @foreach ($programs as $program)
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <img src="{{asset("assets/programs/thumbnail/".$program->thumbnail)}}" alt="..." class="img-fluid">
                    </div>
                    <div class="card-body">
                        <h3><a href="{{route("programs.view",[$program->id,md5($program->title)])}}">{{$program->title}}</a></h3>
                        <h5><i class="mdi mdi-human-male"></i> {{$program->trainer->name}}</h5>
                        <p class="text-dark float-left"><i class="mdi mdi-clipboard-file"></i> {{$program->category->name}}</p>
                        <p class="text-dark float-right"><i class="mdi mdi-currency-inr"></i> {{$program->price}}</p>
                        <a href="{{route("programs.view",[$program->id,md5($program->title)])}}" class="btn btn-block btn-success btn-sm float-right">View</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
        {{$programs->links()}}
    </div>
@endsection