<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\EnrolledCourse;
use App\Models\GroupMember;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\GlobalMail;
use App\Models\Notification;

class EnrollController extends Controller
{
    public function enroll($id){
        $course = Course::find($id);
        if($course===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if(Auth::user()->enrolled_courses->where("course_id",$course->id)->first()!==NULL){
            Session()->flash("warning","You have already enrolled to this course");
            return redirect()->back();
        }
        else{
            if($course->price==0){
                $item = Course::find($id);
                $enroll = new EnrolledCourse;
                $enroll->user_id = Auth::user()->id;
                $enroll->course_id = $item->id;
                $enroll->save();
    
                $groupm = new GroupMember;
                $groupm->group_id = $item->group->id;
                $groupm->user_id = Auth::user()->id;
                $groupm->approved = 1;
                $groupm->save();

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
                Session()->flash('success', "You have successfully enrolled to the course");
                return redirect()->route('courses.view', [$item->id,md5($item->title)]);
            }
            else{
                return redirect()->route('user.payment.choose', ["course",$id]);
            }
        }
    }
}
