<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EnrolledEvent;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\GlobalMail;
use App\Models\Notification;

class EnrollController extends Controller
{
    public function chooseSlot($id,Request $request){
        $event = Event::find($id);
        if($event===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if(Auth::user()->enrolled_events->where("event_id",$event->id)->first()!==NULL){
            Session()->flash("warning","You have already subscribed to this event");
            return redirect()->back();
        }
        else{
            // return view("events.slots")->with([
            //     "event" => $event,
            // ]);
            return $this->enroll($id,$request);
        }
    }
    public function enroll($id,Request $request){
        $event = Event::find($id);
        if($event===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if(Auth::user()->enrolled_events->where("event_id",$event->id)->first()!==NULL){
            Session()->flash("warning","You have already subscribed to this event");
            return redirect()->back();
        }
        else{
            if($event->price==0){
                $item = Event::find($id);
                $enroll = new EnrolledEvent;
                $enroll->user_id = Auth::user()->id;
                $enroll->event_id = $item->id;
                $enroll->save();

                // Mail
                $user = Auth::user();
                $sub = "Welcome to ".$item->title;
                $message="<p>Dear ".$user->name.",</p><p>You have successfully enrolled to ".$item->title.".</p>";
                $data = array('sub'=>$sub,'message'=>$message);
                Mail::to($user->email)->send(new GlobalMail($data));
        
                $notification = new Notification;
                $notification->user_id = $user->id;
                $notification->message = "You have successfully enrolled to ".$item->title;
                $notification->save();
                Session()->flash('success', "You have successfully enrolled to the event event");
                return redirect()->route('events.view', [$item->id,md5($item->title)]);
            }
            else{
                return redirect()->route('user.payment.choose', ["event",$id]);
            }
        }
    }
}
