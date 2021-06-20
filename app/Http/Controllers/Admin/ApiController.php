<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api;
use Brotzka\DotenvEditor\DotenvEditor;

class ApiController extends Controller
{
    public function index(){
        $apis = Api::get()->first();
        if($apis===NULL){
            $apis = new Api;
            $apis->save();
        }
        return view("admin.api")->with([
            "apis"=>$apis
        ]);
    }
    public function update(Request $request){
        $this->validate($request,[
            "razorpay_key_id"=>"required",
            "razorpay_key_secret"=>"required",
            "razorpay_account_no"=>"required",
            "cashfree_appid"=>"required",
            "cashfree_secret"=>"required",
            "cashfree_islive"=>"required",
            "payment_gateway"=>"required",
        ]);
        $apis = Api::get()->first();
        if($apis===NULL){
            return "Please create an API table first";
        }
        else{
            $apis->razorpay_key_id = $request->razorpay_key_id;
            $apis->razorpay_key_secret = $request->razorpay_key_secret;
            $apis->razorpay_account_no = $request->razorpay_account_no;
            $apis->save();
            $env = new DotenvEditor();
            $env->changeEnv([
                'CASHFREE_APPID'=>$request->cashfree_appid,
                'CASHFREE_SECRET'=>$request->cashfree_secret,
                'CASHFREE_ISLIVE'=>$request->cashfree_islive,
                'PAYMENT_GATEWAY'=>$request->payment_gateway,
            ]);
            $request->session()->flash('success', "APIs successfully updated");
            return redirect()->back();
        }
    }
}
