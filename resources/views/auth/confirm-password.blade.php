@extends('layouts.app')
@section("title","Confirm Password")
@section('content')
<div class="pt-32pt pt-sm-64pt pb-32pt">
    <div class="container page__container">
        <div class="mb-4 text-sm text-gray-600">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>
        <form method="POST" action="{{ route('password.confirm') }}" class="col-md-5 p-0 mx-auto">
            @csrf
            <div class="form-group">
                <label class="form-label" for="password">Password:</label>
                <input id="password" type="password" class="form-control" name="password" placeholder="Your password ...">
            </div>
            <div class="text-center">
                <button class="btn btn-primary">Confirm</button>
            </div>
        </form>
    </div>
</div>
@endsection