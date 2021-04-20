<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;

class SettingController extends Controller
{
    public function settings(){
        return view("users.settings");
    }
    public function update(Request $request){
        $this->validate($request,[
            "current_password"=>"required|string|min:8",
            "password"=>"required|string|confirmed|min:8",
        ]);
        $user = Auth::user();
        if(Hash::check($request->current_password, $user->password)){
            $user->password = Hash::make($request->password);
            $request->session()->flash('success', "Password changed successfully");
            Auth::logout();
            return redirect()->back();
        }
        else{
            $request->session()->flash('error', "The current password is incorrect");
            return redirect()->back();
        }
    }
    public function notVerified(){
        return view("user.not-verified");
    }
}
