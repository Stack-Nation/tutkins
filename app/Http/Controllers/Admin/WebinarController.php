<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Webinar;

class WebinarController extends Controller
{
    public function index(){
        $webinars = Webinar::latest()->paginate(15);
        return view("admin.webinars")->with([
            "webinars" => $webinars
        ]);
    }
}
