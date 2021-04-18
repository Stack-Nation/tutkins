<?php

namespace App\Http\Controllers\Mentee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Webinar;
use App\Models\EnrolledWebinar;

class WebinarController extends Controller
{
    public function index(){
        $webinars = EnrolledWebinar::where(["user_id"=>Auth::user()->id])->latest()->paginate(10);
        return view("mentee.webinar.index")->with([
            "webinars"=>$webinars
        ]);
    }
}
