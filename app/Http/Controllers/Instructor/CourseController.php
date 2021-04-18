<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Category;
use App\Models\Language;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\GlobalMail;
use App\Models\Notification;

class CourseController extends Controller
{
    public function index($type="All"){
        if($type==="All"){
            $courses = Course::where(["instructor_id"=>Auth::user()->id,"deleted"=>0])->latest()->paginate(10);
        }
        else if($type==="Pending"){
            $courses = Course::where(["instructor_id"=>Auth::user()->id,"review"=>1,"published"=>0,"deleted"=>0])->latest()->paginate(10);
        }
        else if($type==="Draft"){
            $courses = Course::where(["instructor_id"=>Auth::user()->id,"review"=>0,"deleted"=>0])->latest()->paginate(10);
        }
        else if($type==="Published"){
            $courses = Course::where(["instructor_id"=>Auth::user()->id,"published"=>1,"deleted"=>0])->latest()->paginate(10);
        }
        return view("instructor.courses.index")->with([
            "courses" => $courses,
            "type" => $type,
        ]);
    }
    public function create(){
        $cats = Category::latest()->get();
        return view("instructor.courses.create")->with([
            "cats" => $cats
        ]);
    }
    public function store(Request $request){
        $this->validate($request,[
            "title" => "required|string",
            "sub_title" => "required|string",
            "category" => "required",
            "icon" => "required|image",
        ]);
        $course = new Course;
        $course->instructor_id = Auth::user()->id;
        $course->title = $request->title;
        $course->sub_title = $request->sub_title;
        $course->cid = $request->category;
        if($request->hasFile("icon")){
            $icon = $_FILES["icon"]["name"];
            $tmp = $_FILES["icon"]["tmp_name"];
            $path = "assets/courses/icon/";
            $icon = idate("U").$icon;
            if(\move_uploaded_file($tmp,$path.$icon)){
                $course->icon = $icon;
            }
            else{
                $request->session()->flash('error', "Some problem occured while uploading the icon");
                return redirect()->back();
            }
        }
        $course->save();

        // Mail
        $user = Auth::user();
        $sub = "Your course has been created successfully.";
        $message="<p>Dear ".$user->name.",</p><p>Your course, ".$course->title.", is successfully created.</p>";
        $data = array('sub'=>$sub,'message'=>$message);
        Mail::to($user->email)->send(new GlobalMail($data));

        $notification = new Notification;
        $notification->user_id = $user->id;
        $notification->message = "Your course ".$course->title." is successfully created";
        $notification->save();
        $request->session()->flash('success', "Course Successfully Created");
        return redirect()->route("instructor.courses.edit-land",$course->id);
    }
    public function editLand($id){
        $course = Course::find($id);
        $cats = Category::latest()->get();
        $langs = Language::latest()->get();
        if($course->instructor_id===Auth::user()->id){
            return view("instructor.courses.edit-landing")->with([
                "course" => $course,
                "cats" => $cats,
                "langs" => $langs
            ]);
        }
        else{
            abort(404);
        }
    }
    public function updateLand($id,Request $request){
        $course = Course::find($id);
        if($course->instructor_id===Auth::user()->id){
            $this->validate($request,[
                "title" => "required|string",
                "sub_title" => "required|string",
                "category" => "required",
                "price" => "required",
                "description" => "required",
                "language" => "required",
                "level" => "required",
                "icon" => "nullable",
                "image" => "nullable",
                "video" => "nullable",
            ]);
            $course->title = $request->title;
            $course->sub_title = $request->sub_title;
            $course->cid = $request->category;
            $course->price = $request->price;
            $course->language = $request->language;
            $course->description = $request->description;
            $course->level = $request->level;
            if($request->hasFile("icon")){
                $icon = $_FILES["icon"]["name"];
                $tmp = $_FILES["icon"]["tmp_name"];
                $path = "assets/courses/icon/";
                $icon = idate("U").$icon;
                if(\move_uploaded_file($tmp,$path.$icon)){
                    if($course->icon!==$icon && $course->icon!==NULL){
                        unlink($path.$course->icon);
                    }
                    $course->icon = $icon;
                }
                else{
                    $request->session()->flash('error', "Some problem occured while uploading the icon");
                    return redirect()->back();
                }
            }
            if($request->hasFile("image")){
                $image = $_FILES["image"]["name"];
                $tmp = $_FILES["image"]["tmp_name"];
                $path = "assets/courses/image/";
                $image = idate("U").$image;
                if(\move_uploaded_file($tmp,$path.$image)){
                    if($course->image!==$image && $course->image!==NULL){
                        unlink($path.$course->image);
                    }
                    $course->image = $image;
                }
                else{
                    $request->session()->flash('error', "Some problem occured while uploading the image");
                    return redirect()->back();
                }
            }
            if($request->hasFile("video")){
                $video = $_FILES["video"]["name"];
                $tmp = $_FILES["video"]["tmp_name"];
                $path = "assets/courses/video/";
                $video = idate("U").$video;
                if(\move_uploaded_file($tmp,$path.$video)){
                    if($course->video!==$video && $course->video!==NULL){
                        unlink($path.$course->video);
                    }
                    $course->video = $video;
                }
                else{
                    $request->session()->flash('error', "Some problem occured while uploading the video");
                    return redirect()->back();
                }
            }
            $course->save();

            // Mail
            $user = Auth::user();
            $sub = "Your course is updated.";
            $message="<p>Dear ".$user->name.",</p><p>Your course, ".$course->title.", landing page is updated successfully.</p>";
            $data = array('sub'=>$sub,'message'=>$message);
            Mail::to($user->email)->send(new GlobalMail($data));
    
            $notification = new Notification;
            $notification->user_id = $user->id;
            $notification->message = "Your course ".$course->title." is updated";
            $notification->save();
            $request->session()->flash('success', "Course Successfully updated");
            return redirect()->back();
        }
        else{
            abort(404);
        }
    }
    public function editTarget($id){
        $course = Course::find($id);
        if($course->instructor_id===Auth::user()->id){
            $course->learnings = json_decode($course->learnings);
            $course->requirements = json_decode($course->requirements);
            $course->target = json_decode($course->target);
            return view("instructor.courses.edit-target")->with([
                "course" => $course,
            ]);
        }
        else{
            abort(404);
        }
    }
    public function updateTarget($id,Request $request){
        $course = Course::find($id);
        if($course->instructor_id===Auth::user()->id){
            $this->validate($request,[
                "learnings" => "required",
                "requirements" => "required",
                "targets" => "required",
            ]);
            $course->learnings = json_encode($request->learnings);
            $course->requirements = json_encode($request->requirements);
            $course->target = json_encode($request->targets);
            $course->save();

            // Mail
            $user = Auth::user();
            $sub = "Your course is updated.";
            $message="<p>Dear ".$user->name.",</p><p>Your course, ".$course->title.", targets page is updated successfully.</p>";
            $data = array('sub'=>$sub,'message'=>$message);
            Mail::to($user->email)->send(new GlobalMail($data));
    
            $notification = new Notification;
            $notification->user_id = $user->id;
            $notification->message = "Your course ".$course->title." is updated";
            $notification->save();
            $request->session()->flash('success', "Course Successfully updated");
            return redirect()->back();
        }
        else{
            abort(404);
        }
    }
    public function editCir($id){
        $course = Course::find($id);
        if($course->instructor_id===Auth::user()->id){
            $course->content = \json_decode($course->content);
            return view("instructor.courses.edit-cir")->with([
                "course" => $course,
            ]);
        }
        else{
            abort(404);
        }
    }
    public function updateCir($id,Request $request){
        $course = Course::find($id);
        if($course->instructor_id===Auth::user()->id){
            $this->validate($request,[
                "section_title" => "nullable",
                "section_key" => "nullable",
                "section_objective" => "nullable",
                "lecture_title" => "nullable",
                "type" => "nullable",
                "section_id" => "nullable",
                "quiz_data" => "nullable",
                "lecture_data" => "nullable",
                "lecture_type" => "nullable",
                "question_title" => "nullable",
                "answer1" => "nullable",
                "correct_answer1" => "nullable",
                "answer2" => "nullable",
                "correct_answer2" => "nullable",
                "answer3" => "nullable",
                "correct_answer3" => "nullable",
                "answer4" => "nullable",
                "correct_answer4" => "nullable",
            ]);
            $content = [];
            $i = 0;
            $lecture= 0;
            $quiz = 0;
            $quizd = 0;
            foreach($request->section_key as $key){
                $k = (int)$key;
                $c[$request->section_title[$k]] = [
                    "objective" => $request->section_objective[$k]
                ];
                $di=0;
                foreach($request->section_id as $sid){
                    $id = (int)$sid;
                    if($id == $k){
                        $c[$request->section_title[$k]]["content"][] = [
                            "lecture_title" => $request->lecture_title[$i],
                            "type" => $request->type[$i],
                        ];
                        if($request->type[$i] == "lecture"){
                            if($_FILES["lecture_data"]["size"][$lecture]!==0){
                                $file = \chunk_split(\base64_encode(\file_get_contents($_FILES["lecture_data"]["tmp_name"][$lecture])));
                                $ext = explode(".",$_FILES["lecture_data"]["name"][$lecture])[1];
                                if($request->lecture_type[$lecture]==="video"){
                                    $file = "data:video/".$ext.";base64,".$file;
                                }
                                else{
                                    $file = "data:application/".$ext.";base64,".$file;
                                }
                            }
                            else{
                                $file = $request->lecture_data[$lecture];
                            }
                            $c[$request->section_title[$k]]["content"][$di]["data"][] = [
                                "type" => $request->lecture_type[$lecture],
                                "data" => $file
                            ];
                            $lecture++;
                        }
                        else{
                            $qz = (int)$request->quiz_data[$quizd];
                            for($q = $quiz; $q<$quiz+$qz;$q++){
                                $c[$request->section_title[$k]]["content"][$di]["data"][] = [
                                    "question_title" => $request->question_title[$q],
                                    "answers"=>[
                                        ["answer"=>$request->answer1[$q],"iscorrect"=>$request->correct_answer1[$q]],
                                        ["answer"=>$request->answer2[$q],"iscorrect"=>$request->correct_answer2[$q]],
                                        ["answer"=>$request->answer3[$q],"iscorrect"=>$request->correct_answer3[$q]],
                                        ["answer"=>$request->answer4[$q],"iscorrect"=>$request->correct_answer4[$q]],
                                    ]
                                ];
                            }
                            $quiz = $quiz + $qz;
                            $quizd++;
                        }
                        $i++;
                        $di++;
                    }
                }
            }
            $content = $c;
            $course->content = $content;
            $course->save();

            // Mail
            $user = Auth::user();
            $sub = "Your course is updated.";
            $message="<p>Dear ".$user->name.",</p><p>Your course, ".$course->title.", curriculum is updated successfully.</p>";
            $data = array('sub'=>$sub,'message'=>$message);
            Mail::to($user->email)->send(new GlobalMail($data));
    
            $notification = new Notification;
            $notification->user_id = $user->id;
            $notification->message = "Your course ".$course->title." is updated";
            $notification->save();
            $request->session()->flash('success', "Course Successfully updated");
            return redirect()->back();
        }
        else{
            abort(404);
        }
    }
    public function editSettings($id){
        $course = Course::find($id);
        if($course->instructor_id===Auth::user()->id){
            return view("instructor.courses.edit-settings")->with([
                "course" => $course,
            ]);
        }
        else{
            abort(404);
        }
    }

    public function review($id,Request $request){
        $course = Course::find($id);
        if($course->instructor_id===Auth::user()->id){
            $course->review = 1;
            $course->save();

            // Mail
            $user = Auth::user();
            $sub = "Your course is submitted for review.";
            $message="<p>Dear ".$user->name.",</p><p>Your course, ".$course->title.", is submitted for review.</p>";
            $data = array('sub'=>$sub,'message'=>$message);
            Mail::to($user->email)->send(new GlobalMail($data));
    
            $notification = new Notification;
            $notification->user_id = $user->id;
            $notification->message = "Your course ".$course->title." is submitted for review";
            $notification->save();
            $request->session()->flash('success', "Course submitted for review");
            return redirect()->back();
        }
        else{
            abort(404);
        }
    }
    public function publish($id,Request $request){
        $course = Course::find($id);
        if($course->instructor_id===Auth::user()->id){
            if($course->published === 1){
                $course->published = 0;

                // Mail
                $user = Auth::user();
                $sub = "Your course is unpublished.";
                $message="<p>Dear ".$user->name.",</p><p>Your course, ".$course->title.", is unpublished.</p>";
                $data = array('sub'=>$sub,'message'=>$message);
                Mail::to($user->email)->send(new GlobalMail($data));
        
                $notification = new Notification;
                $notification->user_id = $user->id;
                $notification->message = "Your course ".$course->title." is unpublished";
                $notification->save();
                $request->session()->flash('success', "Course unpublished");
            }
            else{
                $course->published = 1;

                // Mail
                $user = Auth::user();
                $sub = "Your course is published.";
                $message="<p>Dear ".$user->name.",</p><p>Your course, ".$course->title.", is published.</p>";
                $data = array('sub'=>$sub,'message'=>$message);
                Mail::to($user->email)->send(new GlobalMail($data));
        
                $notification = new Notification;
                $notification->user_id = $user->id;
                $notification->message = "Your course ".$course->title." is published";
                $notification->save();
                $request->session()->flash('success', "Course published");
            }
            $course->save();
            return redirect()->back();
        }
        else{
            abort(404);
        }
    }
    public function delete($id,Request $request){
        $course = Course::find($id);
        if($course->instructor_id===Auth::user()->id){
            $course->deleted = 1;
            $course->save();

            // Mail
            $user = Auth::user();
            $sub = "Your course is deleted.";
            $message="<p>Dear ".$user->name.",</p><p>Your course, ".$course->title.", is deleted successfully.</p>";
            $data = array('sub'=>$sub,'message'=>$message);
            Mail::to($user->email)->send(new GlobalMail($data));
    
            $notification = new Notification;
            $notification->user_id = $user->id;
            $notification->message = "Your course ".$course->title." is deleted";
            $notification->save();
            $request->session()->flash('success', "Course deleted");
            return redirect()->route("instructor.courses");
        }
        else{
            abort(404);
        }
    }
}
