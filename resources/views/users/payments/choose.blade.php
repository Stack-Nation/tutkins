<?php
    $image = "";
    $total = $item->price;
    if($type=="program"){
        if($date==NULL or $time==NULL){
            echo "<script>history.back()</script>";
        }
        $image = asset("assets/programs/thumbnail/".$item->thumbnail);
        if($item->discount){
            $total=$item->discount;
        }
        if($typee=="Trial"){
            $total = $item->trial_price;
        }
    }
    else if($type=="event"){
        $image = asset("assets/events/thumbnail/".$item->thumbnail);
        if($item->discount){
            $total=$item->discount;
        }
    }
?>
@extends('layouts.app')
@section("title","Checkout")
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <h3 class="page-title">Checkout</h3>
        </div>
        
    </div>
</div>

<!-- Main content -->
<section class="content">

  <div class="row">
    <div class="col-12">
        <div class="box">
          <div class="box-header">
            <h4 class="box-title">Product Summary</h4>
          </div>
          <div class="box-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th class="w-200">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><img src="{{$image}}" alt="" width="80"></td>
                            <td>{{$item->title}}</td>
                            <td>1</td>
                            <td>{{$total}} INR</td>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right">Total</th>
                            <th>{{$total}} INR</th>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right font-size-24 font-weight-700">Payable Amount</th>
                            <th class="font-size-24 font-weight-700">{{$total}} INR</th>
                        </tr>
                        @if($type=="program")<tr>
                            <td colspan="4">Timing: {{json_encode($date)}} {{json_encode($time)}}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            @if(env("PAYMENT_GATEWAY")=="RAZORPAY")
                <form action="{{route('user.payment.razorpay',[$type,$item->id])}}" method="POST" >
                @if($type=="program")<input type="text" name="date" value="{{json_encode($date)}}" hidden>
                <input type="text" name="typee" value="{{$typee}}" hidden>
                <input type="text" name="time" value="{{json_encode($time)}}" hidden>@endif
                <script src="https://checkout.razorpay.com/v1/checkout.js"
                        data-key="{{ \App\Models\Api::first()->razorpay_key_id }}"
                        data-amount="{{$total*100}}"
                        data-buttontext="Checkout"
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
            @elseif(env("PAYMENT_GATEWAY")=="CASHFREE")
            <form action="{{route('user.payment.cashfree',[$type,$item->id])}}" method="POST" >
            @if($type=="program")<input type="text" name="date" value="{{json_encode($date)}}" hidden>
            <input type="text" name="typee" value="{{$typee}}" hidden>
            <input type="text" name="time" value="{{json_encode($time)}}" hidden>@endif
            <input type="hidden" name="_token" value="{!!csrf_token()!!}">
            <input type="hidden" name="amount" value="{{$total}}">
            <button class="btn btn-danger">Pay</button>
            </form>
            @endif

            <hr>
          </div>
        </div>
    </div>
</div>

</section>
<!-- /.content -->
@endsection
@section('scripts')
<script>
    window.onload = () => {
        $(".razorpay-payment-button").addClass("btn btn-danger")
    }
</script>
@endsection