<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function profile(){
        $user = Auth::user();
        return view("institution.profile")->with([
            "user"=>$user,
        ]);
    }
    public function update(Request $request){
        $this->validate($request,[
            "name" => "required|string",
            "email" => "required|email",
            "mobile" => "required",
            "description" => "required",
            "category" => "required",
            "brand_name" => "required",
            "founded_by" => "nullable",
            "founded" => "nullable",
            "country" => "nullable",
            "state" => "nullable",
            "city" => "nullable",
            "address" => "nullable",
            "pin_code" => "nullable",
            "poc_name" => "nullable",
            "poc_email" => "nullable",
            "poc_mobile" => "nullable",
            "poc_identity" => "nullable",
            "photo" => "nullable",
            "poc_residence" => "nullable",
            "reg_doc" => "nullable",
            "gstin" => "nullable",
            "gst_doc" => "nullable",
            "cin" => "nullable",
            "company_master" => "nullable",
        ]);
        $user = Auth::user();
        $user->name = $request->name;
        $user->description = $request->description;
        if($user->email !== $request->email){
            if(User::where("email",$request->email)->exists()){
                $request->session()->flash('error', "The email already exists");
                return redirect()->back();
            }
        }
        $user->email = $request->email;
        if($user->mobile !== $request->mobile){
            if(User::where("mobile",$request->mobile)->exists()){
                $request->session()->flash('error', "The mobile number already exists");
                return redirect()->back();
            }
        }
        $user->mobile = $request->mobile;
        $user->category = $request->category;
        $user->brand_name = $request->brand_name;
        $user->founded_by = $request->founded_by;
        $user->founded = $request->founded;
        $user->country = $request->country;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->address = $request->address;
        $user->pin_code = $request->pin_code;
        $user->poc_name = $request->poc_name;
        $user->poc_email = $request->poc_email;
        $user->poc_mobile = $request->poc_mobile;
        $user->gstin = $request->gstin;
        $user->cin = $request->cin;
        if($request->hasFile("photo")){
            $path = "assets/users/photo/";
            $name = $_FILES["photo"]["name"];
            $tmp_name = $_FILES["photo"]["tmp_name"];
            $name = idate("U").$name;
            if(\move_uploaded_file($tmp_name,$path.$name)){
                if($user->photo!==NULL){
                    unlink($path.$user->photo);
                }
                $user->photo = $name;
            }
            else{
                $request->session()->flash('error', "There is some error in uploading photo");
                return redirect()->back();
            }
        }
        if($request->hasFile("poc_identity")){
            $path = "assets/users/poc_identity/";
            $name = $_FILES["poc_identity"]["name"];
            $tmp_name = $_FILES["poc_identity"]["tmp_name"];
            $name = idate("U").$name;
            if(\move_uploaded_file($tmp_name,$path.$name)){
                if($user->poc_identity!==NULL){
                    unlink($path.$user->poc_identity);
                }
                $user->poc_identity = $name;
            }
            else{
                $request->session()->flash('error', "There is some error in uploading a document");
                return redirect()->back();
            }
        }
        if($request->hasFile("poc_residence")){
            $path = "assets/users/poc_residence/";
            $name = $_FILES["poc_residence"]["name"];
            $tmp_name = $_FILES["poc_residence"]["tmp_name"];
            $name = idate("U").$name;
            if(\move_uploaded_file($tmp_name,$path.$name)){
                if($user->poc_residence!==NULL){
                    unlink($path.$user->poc_residence);
                }
                $user->poc_residence = $name;
            }
            else{
                $request->session()->flash('error', "There is some error in uploading a document");
                return redirect()->back();
            }
        }
        if($request->hasFile("reg_doc")){
            $path = "assets/users/reg_doc/";
            $name = $_FILES["reg_doc"]["name"];
            $tmp_name = $_FILES["reg_doc"]["tmp_name"];
            $name = idate("U").$name;
            if(\move_uploaded_file($tmp_name,$path.$name)){
                if($user->reg_doc!==NULL){
                    unlink($path.$user->reg_doc);
                }
                $user->reg_doc = $name;
            }
            else{
                $request->session()->flash('error', "There is some error in uploading a document");
                return redirect()->back();
            }
        }
        if($request->hasFile("gst_doc")){
            $path = "assets/users/gst_doc/";
            $name = $_FILES["gst_doc"]["name"];
            $tmp_name = $_FILES["gst_doc"]["tmp_name"];
            $name = idate("U").$name;
            if(\move_uploaded_file($tmp_name,$path.$name)){
                if($user->gst_doc!==NULL){
                    unlink($path.$user->gst_doc);
                }
                $user->gst_doc = $name;
            }
            else{
                $request->session()->flash('error', "There is some error in uploading a document");
                return redirect()->back();
            }
        }
        if($request->hasFile("company_master")){
            $path = "assets/users/company_master/";
            $name = $_FILES["company_master"]["name"];
            $tmp_name = $_FILES["company_master"]["tmp_name"];
            $name = idate("U").$name;
            if(\move_uploaded_file($tmp_name,$path.$name)){
                if($user->company_master!==NULL){
                    unlink($path.$user->company_master);
                }
                $user->company_master = $name;
            }
            else{
                $request->session()->flash('error', "There is some error in uploading a document");
                return redirect()->back();
            }
        }
        $user->save();
        $request->session()->flash('success', "Profile successfully updated");
        return redirect()->back();
    }
}
