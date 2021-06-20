@extends('layouts.authApp')
@section("title","APIs")
@section('content')
<div class="container page__container page-section pb-0">
    <h1 class="h2 mb-4">APIs</h1>
    
    <div class="container page__container page-section">
        <form action="{{route("admin.apis")}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label" for="razorpay_key_id">Razorpay Key ID:</label>
                <input id="razorpay_key_id" type="text" class="form-control form-control-sm" name="razorpay_key_id" value="{{$apis->razorpay_key_id}}">
            </div>
            <div class="form-group">
                <label class="form-label" for="razorpay_key_secret">Razorpay Key Secret:</label>
                <input id="razorpay_key_secret" type="text" class="form-control form-control-sm" name="razorpay_key_secret" value="{{$apis->razorpay_key_secret}}">
            </div>
            <div class="form-group">
                <label class="form-label" for="razorpay_account_no">Razorpay Account Number:</label>
                <input id="razorpay_account_no" type="text" class="form-control form-control-sm" name="razorpay_account_no" value="{{$apis->razorpay_account_no}}">
            </div>
            <div class="form-group">
                <label class="form-label" for="cashfree_appid">Cashfree Appid:</label>
                <input id="cashfree_appid" type="text" class="form-control form-control-sm" name="cashfree_appid" value="{{env("CASHFREE_APPID")}}">
            </div>
            <div class="form-group">
                <label class="form-label" for="cashfree_secret">Cashfree Secret:</label>
                <input id="cashfree_secret" type="text" class="form-control form-control-sm" name="cashfree_secret" value="{{env("CASHFREE_SECRET")}}">
            </div>
            <div class="form-group">
                <label class="form-label" for="cashfree_islive">Cashfree Production:</label>
                <select name="cashfree_islive" id="cashfree_islive" class="custom-select">
                    <option value="true" @if((bool)env("CASHFREE_ISLIVE")===true)selected @endif>Yes</option>
                    <option value="false" @if((bool)env("CASHFREE_ISLIVE")===false)selected @endif>No</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label" for="payment_gateway">Payment Gateway:</label>
                <select name="payment_gateway" id="payment_gateway" class="custom-select">
                    <option value="RAZORPAY" @if(env("PAYMENT_GATEWAY")==="RAZORPAY")selected @endif>RAZORPAY</option>
                    <option value="CASHFREE" @if(env("PAYMENT_GATEWAY")==="CASHFREE")selected @endif>CASHFREE</option>
                </select>
            </div>
            <button class="btn btn-primary">Update</button>
        </form>

    </div>
</div>
@endsection