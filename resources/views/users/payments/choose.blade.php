<?php 
    if($type=="mentoring" and ($date==NULL or $time==NULL)){
        echo "<script>history.back()</script>";
    }
    $image = "";
    $discount=0;
    $total = $item->price;
    if($type=="course"){
        $image = asset("assets/courses/image/".$item->image);
    }
    else if($type=="webinar"){
        $image = asset("assets/webinars/thumbnail/".$item->thumbnail);
        $discount = $total * $item->discount/100;
        $total = $total - $discount;
    }
    else if($type=="mentoring"){
        $image = asset("assets/mentorings/thumbnail/".$item->thumbnail);
    }
?>
@extends('layouts.authApp')
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
                            <td>{{$item->price}} INR</td>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right">Total</th>
                            <th>{{$item->price}} INR</th>
                        </tr>
                        <tr>
                            <td colspan="3" align="right">Discount</td>
                            <td>{{$discount}} INR</td>
                        </tr>
                        <tr>
                            <th colspan="3" class="text-right font-size-24 font-weight-700">Payable Amount</th>
                            <th class="font-size-24 font-weight-700">{{$total}} INR</th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <form action="{{route('user.payment.razorpay',[$type,$item->id])}}" method="POST" >
              <input type="date" name="date" value="{{$date}}" hidden>
              <input type="time" name="time" value="{{$time}}" hidden>
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