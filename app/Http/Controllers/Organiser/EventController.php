<?php

namespace App\Http\Controllers\Organiser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EnrolledEvent;
use App\Models\Category;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\GlobalMail;
use App\Models\Notification;

class EventController extends Controller
{
    public function index(){
        $events = Event::where("organiser_id",Auth::user()->id)->latest()->paginate(15);
        return view("organiser.event.index")->with([
            "events" => $events
        ]);
    }
    public function create(){
        $categories = Category::latest()->get();
        $user = Auth::user();
        return view("organiser.event.create")->with([
            "categories" => $categories,
            "user" => $user
        ]);
    }
    public function subscribers($id){
        $event = Event::find($id);
        if($event===NULL){
            abort(404);
        }
        else{
            if($event->organiser_id!==Auth::user()->id){
                abort(404);
            }
            else{
                $subscribers = EnrolledEvent::where("event_id",$event->id)->latest()->paginate(15);
                return view("organiser.event.subscribers")->with([
                    "subscribers" => $subscribers,
                ]);
            }
        }
    }
    public function store(Request $request){
        $this->validate($request,[
            "title"=>"required",
            "category"=>"required",
            "description"=>"required",
            "instructions"=>"required",
            "mode"=>"required",
            "days"=>"required",
            "link"=>"nullable",
            "country" => "nullable",
            "state" => "nullable",
            "city" => "nullable",
            "address" => "nullable",
            "pin_code" => "nullable",
            "thumbnail"=>"required|image",
            "images"=>"required",
            "dates"=>"required",
            "times"=>"required",
            "price"=>"required",
            "duration"=>"required",
            "durationt"=>"required",
            "video"=>"required",
        ]);
        $event = new Event;
        $event->title = $request->title;
        $event->description = $request->description;
        $event->instructions = $request->instructions;
        $event->mode = $request->mode;
        $event->days = $request->days;
        $event->link = $request->link;
        $event->country = $request->country;
        $event->state = $request->state;
        $event->city = $request->city;
        $event->address = $request->address;
        $event->pin_code = $request->pin_code;
        $event->category_id = $request->category;
        $event->organiser_id = Auth::user()->id;
        $event->dates = json_encode($request->dates);
        $event->times = json_encode($request->times);
        $event->price = $request->price;
        $event->duration = $request->duration." ".$request->durationt;
        if($request->hasFile("thumbnail")){
            $tpath = "assets/events/thumbnail/";
            $name = $_FILES["thumbnail"]["name"];
            $tmp = $_FILES["thumbnail"]["tmp_name"];
            $name = idate("U").$name;
            if(\move_uploaded_file($tmp,$tpath.$name)){
                $event->thumbnail = $name;
            }
            else{
                $request->session()->flash('error', "There is some problem in uploading thumbnail");
                return redirect()->back();
            }
        }
        if($request->hasFile("video")){
            $tpath = "assets/events/video/";
            $name = $_FILES["video"]["name"];
            $tmp = $_FILES["video"]["tmp_name"];
            $name = idate("U").$name;
            if(\move_uploaded_file($tmp,$tpath.$name)){
                $event->video = $name;
            }
            else{
                $request->session()->flash('error', "There is some problem in uploading video");
                return redirect()->back();
            }
        }
        $images = [];
        foreach($_FILES["images"]["tmp_name"] as $key => $img){
            $ext = explode(".",$_FILES["images"]["name"][$key])[1];
            $name = \chunk_split(\base64_encode(\file_get_contents($img)));
            $name = "data:image/".$ext.";base64,".$name;
            $images[] = $name;
        }
        $event->images = \json_encode($images);
        $event->save();

        // Mail
        $user = Auth::user();
        $sub = "Your event has been created successfully.";
        $message="<p>Dear ".$user->name.",</p><p>Your event ".$event->title." is successfully created.</p>";
        $data = array('sub'=>$sub,'message'=>$message);
        Mail::to($user->email)->send(new GlobalMail($data));

        $notification = new Notification;
        $notification->user_id = $user->id;
        $notification->message = "Your event ".$event->title." is successfully created";
        $notification->save();
        $request->session()->flash('success', "Event created.");
        return redirect()->back();
    }
    public function edit($id){
        $event = Event::find($id);
        if($event===NULL){
            abort(404);
        }
        else{
            if($event->organiser_id!==Auth::user()->id){
                abort(404);
            }
            else{
                $categories = Category::latest()->get();
                return view("organiser.event.edit")->with([
                    "event" => $event,
                    "categories" => $categories,
                ]);
            }
        }
    }
    public function update($id,Request $request){
        $this->validate($request,[
            "title"=>"required",
            "category"=>"required",
            "description"=>"required",
            "instructions"=>"required",
            "mode"=>"required",
            "days"=>"required",
            "link"=>"nullable",
            "country" => "nullable",
            "state" => "nullable",
            "city" => "nullable",
            "address" => "nullable",
            "pin_code" => "nullable",
            "price"=>"required",
            "duration"=>"required",
        ]);
        $event = Event::find($id);
        if($event===NULL){
            abort(404);
        }
        else{
            if($event->organiser_id!==Auth::user()->id){
                abort(404);
            }
            else{
                $event->title = $request->title;
                $event->description = $request->description;
                $event->instructions = $request->instructions;
                $event->mode = $request->mode;
                $event->days = $request->days;
                $event->link = $request->link;
                $event->country = $request->country;
                $event->state = $request->state;
                $event->city = $request->city;
                $event->address = $request->address;
                $event->pin_code = $request->pin_code;
                $event->category_id = $request->category;
                $event->price = $request->price;
                $event->duration = $request->duration;
                $event->save();
        
                // Mail
                $user = Auth::user();
                $sub = "Your event has been updated successfully.";
                $message="<p>Dear ".$user->name.",</p><p>Your event ".$event->title." is successfully updated.</p>";
                $data = array('sub'=>$sub,'message'=>$message);
                Mail::to($user->email)->send(new GlobalMail($data));
        
                $notification = new Notification;
                $notification->user_id = $user->id;
                $notification->message = "Your event ".$event->title." is successfully updated";
                $notification->save();
                $request->session()->flash('success', "Event updated.");
                return redirect()->back();
            }
        }
    }
    public function delete(Request $request){
        $this->validate($request,[
            "id"=>"required"
        ]);
        $event = Event::find($request->id);
        if($event===NULL){
            abort(404);
        }
        else{
            if($event->organiser_id!==Auth::user()->id){
                abort(404);
            }
            else{
                unlink("assets/events/thumbnail/".$event->thumbnail);
                unlink("assets/events/video/".$event->video);
                EnrolledEvent::where("event_id",$event->id)->delete();
                $event->delete();
                $request->session()->flash('success', "Event successfully deleted");
                return redirect()->back();
            }
        }
    }
}
