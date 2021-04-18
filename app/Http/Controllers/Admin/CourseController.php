<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Group;
use App\Models\Forum;
use App\Models\GroupMember;
use Illuminate\Support\Facades\Mail;
use App\Mail\GlobalMail;
use App\Models\Notification;

class CourseController extends Controller
{
    public function index($type="Approved"){
        if($type==="Approved"){
            $courses = Course::where(["approved"=>1,"deleted"=>0])->latest()->paginate(10);
        }
        else{
            $courses = Course::where(["review"=>1,"approved"=>0,"deleted"=>0])->latest()->paginate(10);
        }
        return view("admin.courses")->with([
            "courses" => $courses,
            "type" => $type
        ]);
    }
    public function approve(Request $request){
        $this->validate($request,[
            "id"=>"required"
        ]);
        $course = Course::find($request->id);
        // Creating group
        $group = new Group;
        $group->name = $course->title;
        $group->description = $course->description;
        copy("assets/courses/image/".$course->image,"assets/groups/photo/".$course->image);
        $group->photo = $course->image;
        $group->owner_id = $course->instructor_id;
        $group->course_id = $course->id;
        $group->cid = $course->cid;
        $group->private = 1;
        $group->save();

        $groupm = new GroupMember;
        $groupm->group_id = $group->id;
        $groupm->user_id = $course->instructor_id;
        $groupm->approved = 1;
        $groupm->save();

        // Creating forum
        $forum = new Forum;
        $forum->name = $course->title;
        $forum->course_id = $course->id;
        $forum->cid = $course->cid;
        $forum->save();

        $course->approved = 1;
        $course->group_id = $group->id;
        $course->forum_id = $forum->id;
        $course->save();

        // Mail
        $user = $course->instructor;
        $sub = "Your course is live!";
        $message="<p>Dear ".$user->name.",</p><p>Your course ".$course->title." is approved.</p>";
        $data = array('sub'=>$sub,'message'=>$message);
        Mail::to($user->email)->send(new GlobalMail($data));

        $notification = new Notification;
        $notification->user_id = $user->id;
        $notification->message = "Your course ".$course->title." is approved";
        $notification->save();
        $request->session()->flash('success', "Course approved");
        return redirect()->back();
    }
    public function reject(Request $request){
        $this->validate($request,[
            "id"=>"required"
        ]);
        $course = Course::find($request->id);
        $course->deleted = 1;
        $course->save();

        // Mail
        $user = $course->instructor;
        $sub = "Your course is rejected!";
        $message="<p>Dear ".$user->name.",</p><p>Your course ".$course->title." is rejected.</p>";
        $data = array('sub'=>$sub,'message'=>$message);
        Mail::to($user->email)->send(new GlobalMail($data));

        $notification = new Notification;
        $notification->user_id = $user->id;
        $notification->message = "Your course ".$course->title." is rejected";
        $notification->save();
        $request->session()->flash('success', "Course rejected");
        return redirect()->back();
    }
}
