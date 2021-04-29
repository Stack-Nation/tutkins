<?php

namespace App\Http\Controllers\Kid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function index(){
        $user = Auth::user();
        return view("kid.profile")->with([
            "user"=>$user
        ]);
    }
    public function update(Request $request){
        $this->validate($request,[
            "name" => "required|string",
            "email" => "required|email",
            "mobile" => "required",
            "description" => "required",
            "dob" => "nullable",
            "country" => "nullable",
            "state" => "nullable",
            "city" => "nullable",
            "address" => "nullable",
            "pin_code" => "nullable",
            "aadhar" => "nullable",
            "photo" => "nullable",
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
        $user->dob = $request->dob;
        $user->country = $request->country;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->address = $request->address;
        $user->pin_code = $request->pin_code;
        $user->aadhar = $request->aadhar;
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
        $user->save();
        $request->session()->flash('success', "Profile successfully updated");
        return redirect()->back();
    }
    public function view($id){
        $user = User::find($id);
        return view("kid.view-profile")->with([
            "user"=>$user
        ]);
    }
}
