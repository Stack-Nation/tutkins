<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index($type="User"){
        if($type==="User"){
            $users = User::latest()->paginate(10);
        }
        else{
            $users = User::where("role",$type)->latest()->paginate(10);
        }
        return view("admin.users")->with([
            "users" => $users,
            "type" => $type
        ]);
    }
    public function pending($type="User"){
        if($type==="User"){
            $users = User::where("approved",0)->where("role","!=","Admin")->where("role","!=","Kid")->latest()->paginate(10);
        }
        else{
            $users = User::where(["role"=>$type,"approved",0])->latest()->paginate(10);
        }
        return view("admin.pending-users")->with([
            "users" => $users,
            "type" => $type
        ]);
    }
    public function approve(Request $request){
        $this->validate($request,[
            "id" => "required"
        ]);
        $user = User::find($request->id);
        $user->approved = 1;
        $user->save();
        $request->session()->flash('success', "User approved");
        return redirect()->back();
    }
    public function deny(Request $request){
        $this->validate($request,[
            "id" => "required"
        ]);
        $user = User::find($request->id)->delete();
        $request->session()->flash('success', "User deleted");
        return redirect()->back();
    }
}
