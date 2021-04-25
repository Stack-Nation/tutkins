<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index(){
        $events = Event::latest()->paginate(15);
        return view("admin.events")->with([
            "events" => $events
        ]);
    }
}
