<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api;

class ZoomController extends Controller
{
    public function auth(){
        print_r($_REQUEST);
    }
}
