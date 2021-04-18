@extends('layouts.app')
@section("title","Login")
@section('content')
<form class="row p-4 d-flex justify-content-center" action="{{ route('login') }}" method="POST">
    @csrf
    <div class="col-12 text-center mb-5">
        <h1>Sign in</h1>
        <span>Access your Dashboard Now.</span>
    </div>
    <div class="col-10">
        <div class="mb-2">
            <label class="form-label">Email address</label>
            <input type="email" name="email" class="form-control form-control-sm" placeholder="name@example.com">
        </div>
    </div>
    <div class="col-10">
        <div class="mb-2">
            <div class="form-label">
                <span class="d-flex justify-content-between align-items-center">
                    Password
                    <a class="text-secondary" href="{{ route('password.request') }}">Forgot Password?</a>
                </span>
            </div>
            <input type="password" name="password" class="form-control form-control-sm" placeholder="***************">
        </div>
    </div>
    <div class="col-9">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
                Remember me
            </label>
        </div>
    </div>
    <div class="col-4 text-center mt-4">
        <button class="btn btn-block btn-primary lift text-uppercase" atl="signin" type="submit">SIGN IN</button>
    </div>
    <div class="col-12 text-center mt-4">
        <span class="text-muted">Don't have an account yet? <a href="{{route("getting-started")}}" class="text-secondary">Sign up here</a></span>
    </div>
</form>
@endsection