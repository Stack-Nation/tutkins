@extends('layouts.app')
@section("title","Pay using razorpay")
@section('content')
<div class="panel-body mt-4 text-center">
    <form action="{{route('user.payment.razorpay',[$type,$item->id])}}" method="POST" >
        <script src="https://checkout.razorpay.com/v1/checkout.js"
                data-key="{{ \App\Models\Api::first()->razorpay_key_id }}"
                data-amount="{{$item->price*100}}"
                data-buttontext="Click here to pay"
                data-name="{{config("app.name")}}"
                data-description="{{strtoupper($type)}} Value"
                data-image="{{asset("assets/main/images/logo.png")}}"
                data-prefill.name="{{Auth::user()->name}}"
                data-prefill.email="{{Auth::user()->email}}"
                data-prefill.phone="{{Auth::user()->mobile}}"
                data-theme.color="#E33A50">
        </script>
        <input type="hidden" name="_token" value="{!!csrf_token()!!}">
    </form>
</div>
@endsection
@section('scripts')
<script>
    window.onload = () => {
        $(".razorpay-payment-button").addClass("btn btn-primary")
    }
</script>
@endsection