<?php

namespace App\Http\Controllers\Program;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\EnrolledProgram;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\GlobalMail;
use App\Models\Notification;

class EnrollController extends Controller
{
    public function chooseSlot($id,$type){
        $program = Program::find($id);
        if($program===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if(Auth::user()->enrolled_programs->where(["program_id"=>$program->id,"type"=>$type])->first()!==NULL){
            Session()->flash("warning","You have already subscribed to this program");
            return redirect()->back();
        }
        else{
            return view("programs.slots")->with([
                "program" => $program,
                "type" => $type,
            ]);
        }
    }
    public function enroll($id,Request $request){
        $this->validate($request,[
            "day"=>"required",
            "time"=>"required",
            "type"=>"required",
        ]);
        $program = Program::find($id);
        if($program===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if(Auth::user()->enrolled_programs->where("program_id",$program->id)->first()!==NULL){
            Session()->flash("warning","You have already subscribed to this program");
            return redirect()->back();
        }
        else{
            if(($program->trial_price==0 && $request->type=="Trial") || ($program->price==0 and $request->type=="Full")){
                $item = Program::find($id);
                $enroll = new EnrolledProgram;
                $enroll->user_id = Auth::user()->id;
                $enroll->program_id = $item->id;
                $enroll->day = json_encode($request->day);
                $enroll->time = json_encode($request->time);
                $enroll->type = $request->type;
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
                Session()->flash('success', "You have successfully enrolled to the program program");
                return redirect()->route('programs.view', [$item->id,md5($item->title)]);
            }
            else{
                return redirect()->route('user.payment.choose', ["program",$id])->with(["day"=>$request->day,"time"=>$request->time,"typee"=>$request->type]);
            }
        }
    }
}
