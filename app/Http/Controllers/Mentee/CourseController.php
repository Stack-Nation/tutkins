<?php

namespace App\Http\Controllers\Mentee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EnrolledCourse;
use App\Models\Course;
use App\Models\Classes;
use Auth;

class CourseController extends Controller
{
    public function index(){
        $courses = EnrolledCourse::where(["user_id"=>Auth::user()->id])->latest()->paginate(10);
        return view("mentee.courses.index")->with([
            "courses"=>$courses
        ]);
    }
    public function view($id,$title,$section_id,$lecture_id){
        $course = Course::find($id);
        if($course===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if(Auth::user()->enrolled_courses->where("course_id",$course->id)->first()===NULL){
            abort(404);
        }
        else{
            if($title == md5($course->title)){
                $course->content = json_decode($course->content);
                $course->ratings = json_decode($course->ratings);
                $content = json_decode(json_encode($course->content),true);
                if($course->content->{array_keys($content)[$section_id]}->content[$lecture_id]->type==="quiz"){
                    return view("mentee.courses.quiz")->with([
                        "course"=>$course,
                        "section_id"=>$section_id,
                        "lecture_id"=>$lecture_id,
                    ]);
                }
                else{
                    return view("mentee.courses.view")->with([
                        "course"=>$course,
                        "section_id"=>$section_id,
                        "lecture_id"=>$lecture_id,
                    ]);
                }
            }
            else{
                abort(404);
            }
        }
    }
    public function quiz(Request $request,$id,$title,$section_id,$lecture_id){
        $course = Course::find($id);
        if($course===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if(Auth::user()->enrolled_courses->where("course_id",$course->id)->first()===NULL){
            abort(404);
        }
        else{
            if($title == md5($course->title)){
                $course->content = json_decode($course->content);
                $course->ratings = json_decode($course->ratings);
                $content = json_decode(json_encode($course->content),true);
                $marks = 0;
                foreach($course->content->{array_keys($content)[$section_id]}->content[$lecture_id]->data as $qkey => $quiz){
                    $correct = true;
                    foreach ($quiz->answers as $akey => $answer){
                        if($akey===0){
                            if(isset($request->answer1[$qkey]) and $answer->iscorrect=="0"){
                                $correct = false;
                                break;
                            }
                            if(!isset($request->answer1[$qkey]) and $answer->iscorrect=="1"){
                                $correct = false;
                                break;
                            }
                        }
                        if($akey===1){
                            if(isset($request->answer2[$qkey]) and $answer->iscorrect=="0"){
                                $correct = false;
                                break;
                            }
                            if(!isset($request->answer2[$qkey]) and $answer->iscorrect=="1"){
                                $correct = false;
                                break;
                            }
                        }
                        if($akey===2){
                            if(isset($request->answer3[$qkey]) and $answer->iscorrect=="0"){
                                $correct = false;
                                break;
                            }
                            if(!isset($request->answer3[$qkey]) and $answer->iscorrect=="1"){
                                $correct = false;
                                break;
                            }
                        }
                        if($akey===3){
                            if(isset($request->answer4[$qkey]) and $answer->iscorrect=="0"){
                                $correct = false;
                                break;
                            }
                            if(!isset($request->answer4[$qkey]) and $answer->iscorrect=="1"){
                                $correct = false;
                                break;
                            }
                        }
                    }
                    if($correct===true){
                        $marks++;
                    }
                }
                return view("mentee.courses.quiz_result")->with([
                    "course"=>$course,
                    "section_id"=>$section_id,
                    "lecture_id"=>$lecture_id,
                    "marks"=>$marks,
                ]);
            }
            else{
                abort(404);
            }
        }
    }
    public function feedback($id,$title){
        $course = Course::find($id);
        if($course===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if(Auth::user()->enrolled_courses->where("course_id",$course->id)->first()===NULL){
            abort(404);
        }
        else{
            if($title == md5($course->title)){
                $course->ratings = json_decode($course->ratings);
                $course->content = \json_decode($course->content);
                return view("mentee.courses.feedback")->with([
                    "course"=>$course
                ]);
            }
            else{
                abort(404);
            }
        }
    }
    public function addFeedback($id,$title,Request $request){
        $this->validate($request,[
            "stars" => "required",
            "feedback" => "required",
            "key" => "nullable",
        ]);
        $course = Course::find($id);
        if($course===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if(Auth::user()->enrolled_courses->where("course_id",$course->id)->first()===NULL){
            abort(404);
        }
        else{
            if($title == md5($course->title)){
                $ratings = json_decode($course->ratings);
                if($request->key === NULL){
                    $ratings[] = [
                        "stars"=>$request->stars,
                        "feedback"=>$request->feedback,
                        "user_id" => Auth::user()->id
                    ];
                }
                else{
                    $ratings[$request->key] = [
                        "stars"=>$request->stars,
                        "feedback"=>$request->feedback,
                        "user_id" => Auth::user()->id
                    ];
                }
                $course->ratings = \json_encode($ratings);
                $course->save();
                $request->session()->flash('success', "Feedback submitted");
                return redirect()->back();
            }
            else{
                abort(404);
            }
        }
    }
    public function classes($id,$title){
        $course = Course::find($id);
        if($course===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if(Auth::user()->enrolled_courses->where("course_id",$course->id)->first()===NULL){
            abort(404);
        }
        else{
            if($title == md5($course->title)){
                $course->content = \json_decode($course->content);
                $classes = Classes::where(["course_id"=>$course->id])->latest()->paginate(10);
                return view("mentee.courses.classes")->with([
                    "course" => $course,
                    "classes" => $classes,
                ]);
            }
            else{
                abort(404);
            }
        }
    }
}
