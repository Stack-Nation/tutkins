<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class MainController extends Controller
{
    public function index(){
        $events = Event::latest()->paginate(15);
        return view("events.index")->with([
            "events" => $events
        ]);
    }
    public function view($id,$title){
        $event = Event::find($id);
        if($event){
            if(md5($event->title)==$title){
                $event->images = json_decode($event->images);
                $event->dates = json_decode($event->dates);
                $event->times = json_decode($event->times);
                return view("events.view")->with([
                    "event" => $event
                ]);
            }
            else{
                abort(404);
            }
        }
        else{
            abort(404);
        }
    }
}
