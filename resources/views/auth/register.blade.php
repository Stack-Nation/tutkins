@extends('layouts.app')
@section("title","Register")
@section('content')
<form class="row p-4 w-3 d-flex justify-content-center" method="POST" action="{{ route('register',$role) }}">
    @csrf
    <div class="col-12 text-center mb-5">
        <h3>Create your account</h3>
        <span>Join our Platform Now.</span>
    </div>
    <div class="col-10">
        <div class="mb-2">
            <label class="form-label">Full name</label>
            <input type="text" name="name" class="form-control form-control-sm" placeholder="John Smith">
        </div>
    </div>
    <div class="col-5">
        <div class="mb-2">
            <label class="form-label">Email address</label>
            <input type="email" name="email" class="form-control form-control-sm" placeholder="name@example.com">
        </div>
    </div>
    <div class="col-5">
        <div class="mb-2">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control form-control-sm" placeholder="name234">
        </div>
    </div>
    <div class="col-10">
        <div class="mb-2">
            <label class="form-label">Mobile Number</label>
            <input type="tel" name="mobile" class="form-control form-control-sm" placeholder="Mobile number">
        </div>
    </div>
    <div class="col-5">
        <div class="mb-2">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control form-control-sm" placeholder="8+ characters required">
        </div>
    </div>
    <div class="col-5">
        <div class="mb-2">
            <label class="form-label">Confirm password</label>
            <input type="password" name="password_confirmation" class="form-control form-control-sm" placeholder="8+ characters required">
        </div>
    </div>
    <input name="role" id="role" type="hidden" value="{{$role}}"/>
    <div class="col-9">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
                I accept the <a href="#" title="Terms and Conditions" class="text-secondary">Terms and Conditions</a>
            </label>
        </div>
    </div>
    <div class="col-4 text-center mt-2">
        <button type="submit" class="btn btn-block btn-primary lift text-uppercase" alt="SIGNUP">SIGN UP</button>
    </div>
    <div class="col-12 text-center mt-2">
        <span class="text-muted">Already have an account? <a href="{{route("login")}}" title="Sign in" class="text-secondary">Sign in here</a></span>
    </div>
</form>
@endsection