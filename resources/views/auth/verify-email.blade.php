@extends('layouts.app')
@section("title","Verify Email")
@section('content')
<div class="pt-32pt pt-sm-64pt pb-32pt">
    <div class="container page__container">
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif
        <form method="POST" action="{{ route('verification.send') }}" class="col-md-5 p-0 mx-auto">
            @csrf
            <div class="text-center">
                <button class="btn btn-primary">Resend Verification Email</button>
            </div>
        </form>
    </div>
</div>
@endsection