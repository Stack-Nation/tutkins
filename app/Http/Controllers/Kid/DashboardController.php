<?php

namespace App\Http\Controllers\Kid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view("kid.dashboard");
    }
}
