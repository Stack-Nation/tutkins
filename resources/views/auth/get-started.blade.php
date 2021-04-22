@extends('layouts.app')
@section("title","Get started")
@section('content')
<div class="pt-32pt pt-sm-64pt pb-32pt">
    <div class="container page__container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-8 mb-3">
                <a href="{{route("register","Kid")}}" class="btn btn-default btn-outline-dark btn-block">Kid-Parent</a>
            </div>
            <div class="col-md-8 mb-3">
                <a href="{{route("register","Trainer")}}" class="btn btn-default btn-outline-dark btn-block">Trainer</a>
            </div>
            <div class="col-md-8 mb-3">
                <a href="{{route("register","Organiser")}}" class="btn btn-default btn-outline-dark btn-block">Organiser</a>
            </div>
        </div>
    </div>
</div>
@endsection