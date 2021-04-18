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
            return "Please create an API table first";
        }
        else{
            return view("admin.api")->with([
                "apis"=>$apis
            ]);
        }
    }
    public function update(Request $request){
        $this->validate($request,[
            "paytm_merchant_id"=>"required",
            "paytm_merchant_key"=>"required",
            "paytm_channel"=>"required",
            "paytm_industry"=>"required",
            "paytm_website"=>"required",
            "razorpay_key_id"=>"required",
            "razorpay_key_secret"=>"required",
            "razorpay_account_no"=>"required",
            "zoom_api_key"=>"required",
            "zoom_api_secret"=>"required",
        ]);
        $apis = Api::get()->first();
        if($apis===NULL){
            return "Please create an API table first";
        }
        else{
            $apis->paytm_merchant_id = $request->paytm_merchant_id;
            $apis->paytm_merchant_key = $request->paytm_merchant_key;
            $apis->paytm_channel = $request->paytm_channel;
            $apis->paytm_website = $request->paytm_website;
            $apis->paytm_industry = $request->paytm_industry;
            $apis->razorpay_key_id = $request->razorpay_key_id;
            $apis->razorpay_key_secret = $request->razorpay_key_secret;
            $apis->razorpay_account_no = $request->razorpay_account_no;
            $apis->zoom_api_key = $request->zoom_api_key;
            $apis->zoom_api_secret = $request->zoom_api_secret;
            $apis->save();
            $env = new DotenvEditor();
            $env->changeEnv([
                'PAYTM_MERCHANT_ID'=>$request->paytm_merchant_id,
                'PAYTM_MERCHANT_KEY'=>$request->paytm_merchant_key,
                'PAYTM_CHANNEL'=>$request->paytm_channel,
                'PAYTM_WEBSITE'=>$request->paytm_website,
                'PAYTM_INDUSTRY'=>$request->paytm_industry,
            ]);
            $request->session()->flash('success', "APIs successfully updated");
            return redirect()->back();
        }
    }
}
