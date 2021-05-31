<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;
use Auth;

class MainController extends Controller
{
    public function index(){
        $events = Event::latest()->paginate(15);
        $categories = Category::latest()->get();
        return view("events.index")->with([
            "events" => $events,
            "categories" => $categories,
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
    public function search(Request $request){
        $this->validate($request,[
            "city"=>"nullable",
            "age_group"=>"nullable",
            "category"=>"nullable",
        ]);
        $events = Event::latest();
        if($request->city!=="" and $request->city!==NULL){
            $events = $events->where("city","LIKE","%".$request->city."%");
        }
        if($request->age_group!=="" and $request->age_group!==NULL){
            $events = $events->where("age_group","LIKE","%".$request->age_group."%");
        }
        if($request->category!=="" and $request->category!==NULL){
            $events = $events->where("category_id",$request->category);
        }
        $events = $events->paginate(15);
        $categories = Category::latest()->get();
        return view("events.index")->with([
            "events" => $events,
            "categories" => $categories,
        ]);
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
