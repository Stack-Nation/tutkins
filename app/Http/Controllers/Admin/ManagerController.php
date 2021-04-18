<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class ManagerController extends Controller
{
    public function index(){
        $users = User::where("role","Manager")->latest()->paginate(10);
        return view("admin.managers")->with([
            "users" => $users,
        ]);
    }
    public function create(Request $request){
        $this->validate($request,[
            "name"=>"required|string",
            "email"=>"required|string|email|unique:users",
            "password"=>"required|string|confirmed|min:8",
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = "Manager";
        $user->save();
        $request->session()->flash('success', "Manager successfully created");
        return redirect()->back();
    }
    public function delete(Request $request){
        $this->validate($request,[
            "id"=>"required",
        ]);
        $user = User::find($request->id);
        if($user===NULL){
            $request->session()->flash('error', "The manager does not exist");
            return redirect()->back();
        }
        else{
            $user->delete();
            $request->session()->flash('success', "Manager successfully deleted");
            return redirect()->back();
        }
    }
}
