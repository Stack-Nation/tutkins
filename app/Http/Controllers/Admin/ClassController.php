<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classes;

class ClassController extends Controller
{
    public function index(){
        $classes = Classes::latest()->paginate(10);
        return view("admin.classes")->with([
            "classes" => $classes,
        ]);
    }
}
