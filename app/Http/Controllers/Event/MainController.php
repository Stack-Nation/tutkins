<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Auth;

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
                $event->feedback = json_decode($event->feedback);
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
    public function feedback($id){
        $event = Event::find($id);
        if($event===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if(Auth::user()->enrolled_events->where("event_id",$event->id)->first()===NULL){
            abort(404);
        }
        else{
            $event->feedback = json_decode($event->feedback);
            return view("events.feedback")->with([
                "event"=>$event
            ]);
        }
    }
    public function addFeedback($id,Request $request){
        $this->validate($request,[
            "stars" => "required",
            "feedback" => "required",
            "key" => "nullable",
        ]);
        $event = Event::find($id);
        if($event===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if(Auth::user()->enrolled_events->where("event_id",$event->id)->first()===NULL){
            abort(404);
        }
        else{
            $feedback = json_decode($event->feedback);
            if($request->key === NULL){
                $feedback[] = [
                    "stars"=>$request->stars,
                    "feedback"=>$request->feedback,
                    "user_id" => Auth::user()->id
                ];
            }
            else{
                $feedback[$request->key] = [
                    "stars"=>$request->stars,
                    "feedback"=>$request->feedback,
                    "user_id" => Auth::user()->id
                ];
            }
            $event->feedback = \json_encode($feedback);
            $event->save();
            $request->session()->flash('success', "Feedback submitted");
            return redirect()->back();
        }
    }
}
