<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class MainController extends Controller
{
    public function index(){
        $courses = Course::where(["published"=>1,"deleted"=>0])->latest()->paginate(16);
        foreach($courses as $course){
            $course->learnings = json_decode($course->learnings);
            $course->ratings = json_decode($course->ratings);
        }
        return view("courses.index")->with([
            "courses" => $courses
        ]);
    }
    public function view($id,$title){
        $course = Course::find($id);
        if($course===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if($title == md5($course->title)){
            $course->learnings = json_decode($course->learnings);
            $course->ratings = json_decode($course->ratings);
            $course->requirements = json_decode($course->requirements);
            $course->target = json_decode($course->target);
            $course->content = json_decode($course->content);
            return view("courses.view")->with([
                "course"=>$course,
            ]);
        }
        else{
            abort(404);
        }
    }
}
