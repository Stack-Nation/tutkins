@extends('layouts.app')
@section("title","Forgot Password")
@section('content')
<form class="row p-4 d-flex justify-content-center" method="POST" action="{{ route('password.email') }}">
    <div class="col-12 text-center mb-5">
        <h1>Forgot password?</h1>
        <span>Enter the email address you used when you joined and we'll send you instructions to reset your password.</span>
    </div>
    <div class="col-10">
        <div class="mb-2">
            <label class="form-label">Email address</label>
            <input type="email" name="email" class="form-control form-control-sm" placeholder="name@example.com">
        </div>
    </div>
    <div class="col-4 text-center mt-4">
        <button class="btn btn-block btn-primary lift text-uppercase">SUBMIT</button>
    </div>
    <div class="col-12 text-center mt-4">
        <span class="text-muted"><a href="{{route("login")}}" class="text-secondary">Back to Sign in</a></span>
    </div>
</form>
@endsection