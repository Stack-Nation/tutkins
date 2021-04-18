<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\Course;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\GlobalMail;
use App\Models\Notification;

class ClassController extends Controller
{
    public function index(){
        $classes = Classes::where(["owner_id"=>Auth::user()->id])->latest()->paginate(10);
        return view("instructor.classes.index")->with([
            "classes" => $classes,
        ]);
    }
    public function create(){
        $courses = Course::where(["instructor_id"=>Auth::user()->id,"published"=>1,"deleted"=>0])->latest()->get();
        return view("instructor.classes.create")->with([
            "courses" => $courses
        ]);
    }
    public function store(Request $request){
        $this->validate($request,[
            "title"=>"required",
            "description"=>"required",
            "course"=>"required",
            "thumbnail"=>"required|image",
            "image1"=>"required|image",
            "image2"=>"required|image",
            "date"=>"required",
            "time"=>"required",
            "price"=>"required",
            "duration"=>"required",
            "discount"=>"required",
            "meeting_id"=>"required",
            "meeting_site"=>"required",
        ]);
        $class = new Classes;
        $class->title = $request->title;
        $class->description = $request->description;
        $class->course_id = $request->course;
        $class->owner_id = Auth::user()->id;
        $class->date = $request->date;
        $class->time = $request->time;
        $class->price = $request->price;
        $class->duration = $request->duration;
        $class->discount = $request->discount;
        if($request->hasFile("thumbnail")){
            $tpath = "assets/classes/thumbnail/";
            $name = $_FILES["thumbnail"]["name"];
            $tmp = $_FILES["thumbnail"]["tmp_name"];
            $name = idate("U").$name;
            if(\move_uploaded_file($tmp,$tpath.$name)){
                $class->thumbnail = $name;
            }
            else{
                $request->session()->flash('error', "There is some problem in uploading thumbnail");
                return redirect()->back();
            }
        }
        if($request->hasFile("image1")){
            $i1path = "assets/classes/image1/";
            $name = $_FILES["image1"]["name"];
            $tmp = $_FILES["image1"]["tmp_name"];
            $name = idate("U").$name;
            if(\move_uploaded_file($tmp,$i1path.$name)){
                $class->image1 = $name;
            }
            else{
                unlink($tpath.$class->thumbnail);
                $request->session()->flash('error', "There is some problem in uploading image1");
                return redirect()->back();
            }
        }
        if($request->hasFile("image2")){
            $i2path = "assets/classes/image2/";
            $name = $_FILES["image2"]["name"];
            $tmp = $_FILES["image2"]["tmp_name"];
            $name = idate("U").$name;
            if(\move_uploaded_file($tmp,$i2path.$name)){
                $class->image2 = $name;
            }
            else{
                unlink($tpath.$class->thumbnail);
                unlink($i1path.$class->image1);
                $request->session()->flash('error', "There is some problem in uploading image2");
                return redirect()->back();
            }
        }
        $class->meeting_id = $request->meeting_id;
        $class->meeting_site = $request->meeting_site;
        $class->save();

        // Mail
        $user = Auth::user();
        $sub = "Your live class has been created successfully.";
        $message="<p>Dear ".$user->name.",</p><p>Your live class ".$class->title." is successfully created.</p>";
        $data = array('sub'=>$sub,'message'=>$message);
        Mail::to($user->email)->send(new GlobalMail($data));

        $notification = new Notification;
        $notification->user_id = $user->id;
        $notification->message = "Your class ".$class->title." is successfully created";
        $notification->save();
        $request->session()->flash('success', "Class created");
        return redirect()->back();
    }

    public function start($id,$title){
        $class = Classes::find($id);
        if($class===NULL){
            abort(404);
        }
        if($title === md5($class->title) and $class->owner_id===Auth::user()->id){
            return view("instructor.classes.start")->with([
                "class" => $class,
            ]);
        }
        else{
            abort(404);
        }
    }
}
