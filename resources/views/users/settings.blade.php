@extends('layouts.authApp')
@section("title","Settings")
@section('content')
<div class="pt-32pt pt-sm-64pt pb-32pt">
    <div class="container page__container">
        <form method="POST" action="{{ route('user.settings') }}" class="col-md-5 p-0 mx-auto">
            @csrf
            <div class="form-group">
                <label class="form-label" for="current_password">Current Password:</label>
                <input id="current_password" type="password" class="form-control" name="current_password" required placeholder="Your current password ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="password">New Password:</label>
                <input id="password" type="password" class="form-control" name="password" required placeholder="Your new password ...">
            </div>
            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirm New Password:</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm new password ...">
            </div>
            <div class="text-center">
                <button class="btn btn-primary">Update Password</button>
            </div>
        </form>
    </div>
</div>
@endsection