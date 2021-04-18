@extends('layouts.app')
@section("title","Reset Password")
@section('content')
<div class="pt-32pt pt-sm-64pt pb-32pt">
    <div class="container page__container">
        <form method="POST" action="{{ route('password.update') }}" class="col-md-5 p-0 mx-auto">
            @csrf
            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <div class="form-group">
                <label class="form-label" for="email">Email:</label>
                <input id="email" type="email" value="{{$request->email}}" class="form-control" name="email" placeholder="Your email ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="password">Password:</label>
                <input id="password" type="password" name="password" class="form-control" placeholder="Your password ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirm Password:</label>
                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Confirm your password ...">
            </div>
            <div class="text-center">
                <button class="btn btn-primary">Reset Password</button>
            </div>
        </form>
    </div>
</div>
@endsection