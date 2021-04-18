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
}
