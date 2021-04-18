@extends('layouts.auths')
@section("title","Login")
@section('content')
<form class="row g-1 p-0 p-4" action="{{ route('login') }}" method="POST">
    @csrf
    <div class="col-12 text-center mb-5">
        <h1>Sign in</h1>
        <span>Access your Dashboard Now.</span>
    </div>
    <div class="col-12">
        <div class="mb-2">
            <label class="form-label">Email address</label>
            <input type="email" name="email" class="form-control form-control-lg" placeholder="name@example.com">
        </div>
    </div>
    <div class="col-12">
        <div class="mb-2">
            <div class="form-label">
                <span class="d-flex justify-content-between align-items-center">
                    Password
                    <a class="text-secondary" href="{{ route('password.request') }}">Forgot Password?</a>
                </span>
            </div>
            <input type="password" name="password" class="form-control form-control-lg" placeholder="***************">
        </div>
    </div>
    <div class="col-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
                Remember me
            </label>
        </div>
    </div>
    <div class="col-12 text-center mt-4">
        <button class="btn btn-lg btn-block btn-light lift text-uppercase" atl="signin" type="submit">SIGN IN</button>
    </div>
    <div class="col-12 text-center mt-4">
        <span class="text-muted">Don't have an account yet? <a href="{{route("getting-started")}}" class="text-secondary">Sign up here</a></span>
    </div>
</form>
@endsection