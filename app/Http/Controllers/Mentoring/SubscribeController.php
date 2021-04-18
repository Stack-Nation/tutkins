<?php

namespace App\Http\Controllers\Mentoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mentoring;
use App\Models\EnrolledMentoring;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\GlobalMail;
use App\Models\Notification;

class SubscribeController extends Controller
{
    public function chooseSlot($id){
        $mentoring = Mentoring::find($id);
        if($mentoring===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if(Auth::user()->enrolled_mentorings->where("mentoring_id",$mentoring->id)->first()!==NULL){
            Session()->flash("warning","You have already subscribed to this mentoring program");
            return redirect()->back();
        }
        else{
            return view("mentorings.slots")->with([
                "mentoring" => $mentoring,
            ]);
        }
    }
    public function subscribe($id,Request $request){
        $this->validate($request,[
            "date"=>"required",
            "time"=>"required",
        ]);
        $mentoring = Mentoring::find($id);
        if($mentoring===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if(Auth::user()->enrolled_mentorings->where("mentoring_id",$mentoring->id)->first()!==NULL){
            Session()->flash("warning","You have already subscribed to this mentoring program");
            return redirect()->back();
        }
        else{
            if($mentoring->price==0){
                $item = Mentoring::find($id);
                $enroll = new EnrolledMentoring;
                $enroll->user_id = Auth::user()->id;
                $enroll->mentoring_id = $item->id;
                $enroll->date = $request->date;
                $enroll->time = $request->time;
                $enroll->save();

                // Mail
                $user = Auth::user();
                $sub = "Welcome to ".$item->title;
                $message="<p>Dear ".$user->name.",</p><p>You have successfully subscribed to ".$item->title.".</p>";
                $data = array('sub'=>$sub,'message'=>$message);
                Mail::to($user->email)->send(new GlobalMail($data));
        
                $notification = new Notification;
                $notification->user_id = $user->id;
                $notification->message = "You have successfully subscribed to ".$item->title;
                $notification->save();
                Session()->flash('success', "You have successfully subscribed to the mentoring program");
                return redirect()->route('mentorings.view', [$item->id,md5($item->title)]);
            }
            else{
                return redirect()->route('user.payment.choose', ["mentoring",$id])->with(["date"=>$request->date,"time"=>$request->time]);
            }
        }
    }
    public function fillForm($id){
        $mentoring = Mentoring::find($id);
        if($mentoring===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if(Auth::user()->enrolled_mentorings->where("mentoring_id",$mentoring->id)->first()!==NULL){
            if(Auth::user()->enrolled_mentorings->where("mentoring_id",$mentoring->id)->first()->form_response===NULL){
                $mentoring->form = \json_decode($mentoring->form);
                return view("mentorings.form")->with([
                    "mentoring"=>$mentoring,
                ]);
            }
            else{
                Session()->flash("warning","You have already submitted form for this mentoring program");
                return redirect()->back();
            }
        }
        else{
            abort(404);
        }
    }
    public function submitForm($id,Request $request){
        $mentoring = Mentoring::find($id);
        if($mentoring===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if(Auth::user()->enrolled_mentorings->where("mentoring_id",$mentoring->id)->first()!==NULL){
            if(Auth::user()->enrolled_mentorings->where("mentoring_id",$mentoring->id)->first()->form_response===NULL){
                $user = Auth::user()->enrolled_mentorings->where("mentoring_id",$mentoring->id)->first();
                $mentoring->form = json_decode(json_decode($mentoring->form));
                $formr = [];
                foreach($mentoring->form as $form){
                    $formr[] = [
                        "name"=>$form->name,
                        "label"=>$form->label,
                        "value"=>$request->{$form->name}
                    ];
                }
                $user->form_response = json_encode($formr);
                $user->save();
                $request->session()->flash('success', "Form Submitted");
                return redirect()->route("mentorings.view",[$mentoring->id,md5($mentoring->title)]);
            }
            else{
                Session()->flash("warning","You have already submitted form for this mentoring program");
                return redirect()->back();
            }
        }
        else{
            abort(404);
        }
    }
}
