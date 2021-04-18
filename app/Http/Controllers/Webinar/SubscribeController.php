<?php

namespace App\Http\Controllers\Webinar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Webinar;
use App\Models\EnrolledWebinar;
use App\Models\GroupMember;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\GlobalMail;
use App\Models\Notification;

class SubscribeController extends Controller
{
    public function subscribe($id){
        $webinar = Webinar::find($id);
        if($webinar===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if(Auth::user()->enrolled_webinars->where("webinar_id",$webinar->id)->first()!==NULL){
            Session()->flash("warning","You have already subscribed to this webinar");
            return redirect()->back();
        }
        else{
            if($webinar->price==0){
                $item = Webinar::find($id);
                $enroll = new EnrolledWebinar;
                $enroll->user_id = Auth::user()->id;
                $enroll->webinar_id = $item->id;
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
                Session()->flash('success', "You have successfully subscribed to the webinar");
                return redirect()->route('webinars.view', [$item->id,md5($item->title)]);
            }
            else{
                return redirect()->route('user.payment.choose', ["webinar",$id]);
            }
        }
    }
    public function fillForm($id){
        $webinar = Webinar::find($id);
        if($webinar===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if(Auth::user()->enrolled_webinars->where("webinar_id",$webinar->id)->first()!==NULL){
            if(Auth::user()->enrolled_webinars->where("webinar_id",$webinar->id)->first()->form_response===NULL){
                $webinar->form = \json_decode($webinar->form);
                return view("webinars.form")->with([
                    "webinar"=>$webinar,
                ]);
            }
            else{
                Session()->flash("warning","You have already submitted form for this webinar");
                return redirect()->back();
            }
        }
        else{
            abort(404);
        }
    }
    public function submitForm($id,Request $request){
        $webinar = Webinar::find($id);
        if($webinar===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if(Auth::user()->enrolled_webinars->where("webinar_id",$webinar->id)->first()!==NULL){
            if(Auth::user()->enrolled_webinars->where("webinar_id",$webinar->id)->first()->form_response===NULL){
                $user = Auth::user()->enrolled_webinars->where("webinar_id",$webinar->id)->first();
                $webinar->form = json_decode(json_decode($webinar->form));
                $formr = [];
                foreach($webinar->form as $form){
                    $formr[] = [
                        "name"=>$form->name,
                        "label"=>$form->label,
                        "value"=>$request->{$form->name}
                    ];
                }
                $user->form_response = json_encode($formr);
                $user->save();
                $request->session()->flash('success', "Form Submitted");
                return redirect()->route("webinars.view",[$webinar->id,md5($webinar->title)]);
            }
            else{
                Session()->flash("warning","You have already submitted form for this webinar");
                return redirect()->back();
            }
        }
        else{
            abort(404);
        }
    }
}
