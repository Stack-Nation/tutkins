<?php

namespace App\Http\Controllers\Kid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EnrolledEvent;
use Auth;

class EventController extends Controller
{
    public function index(){
        $events = EnrolledEvent::where("user_id",Auth::user()->id)->latest()->paginate(15);
        return view("kid.events")->with([
            "events" => $events
        ]);
    }
}
