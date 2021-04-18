@extends('layouts.app')
@section("title","Get started")
@section('content')
<div class="pt-32pt pt-sm-64pt pb-32pt">
    <div class="container page__container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-8 mb-3">
                <a href="{{route("register","Mentee")}}" class="btn btn-default btn-outline-dark btn-block">Mentee</a>
            </div>
            <div class="col-md-8 mb-3">
                <a href="{{route("register","Instructor")}}" class="btn btn-default btn-outline-dark btn-block">Instructor</a>
            </div>
            <div class="col-md-8 mb-3">
                <a href="{{route("register","Organisation")}}" class="btn btn-default btn-outline-dark btn-block">Organisation</a>
            </div>
            <div class="col-md-8 mb-3">
                <a href="{{route("register","Institution")}}" class="btn btn-default btn-outline-dark btn-block">Institution</a>
            </div>
        </div>
    </div>
</div>
@endsection