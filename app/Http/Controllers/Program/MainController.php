<?php

namespace App\Http\Controllers\Program;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Category;
use Auth;

class MainController extends Controller
{
    public function index(){
        $programs = Program::latest()->paginate(15);
        $categories = Category::latest()->get();
        return view("programs.index")->with([
            "programs" => $programs,
            "categories" => $categories,
        ]);
    }
    public function view($id,$title){
        $program = Program::find($id);
        if($program){
            if(md5($program->title)==$title){
                $program->images = json_decode($program->images);
                $program->dates = json_decode($program->dates);
                $program->feedback = json_decode($program->feedback);
                $program->times = json_decode($program->times);
                return view("programs.view")->with([
                    "program" => $program
                ]);
            }
            else{
                abort(404);
            }
        }
        else{
            abort(404);
        }
    }
    public function search(Request $request){
        $this->validate($request,[
            "city"=>"nullable",
            "age_group"=>"nullable",
            "category"=>"nullable",
        ]);
        $programs = Program::latest();
        if($request->city!=="" and $request->city!==NULL){
            $programs = $programs->where("city","LIKE","%".$request->city."%");
        }
        if($request->age_group!=="" and $request->age_group!==NULL){
            $programs = $programs->where("age_group","LIKE","%".$request->age_group."%");
        }
        if($request->category!=="" and $request->category!==NULL){
            $programs = $programs->where("category_id",$request->category);
        }
        $programs = $programs->paginate(15);
        $categories = Category::latest()->get();
        return view("programs.index")->with([
            "programs" => $programs,
            "categories" => $categories,
        ]);
    }
    public function feedback($id){
        $program = Program::find($id);
        if($program===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if(Auth::user()->enrolled_programs->where("program_id",$program->id)->first()===NULL){
            abort(404);
        }
        else{
            $program->feedback = json_decode($program->feedback);
            return view("programs.feedback")->with([
                "program"=>$program
            ]);
        }
    }
    public function addFeedback($id,Request $request){
        $this->validate($request,[
            "stars" => "required",
            "feedback" => "required",
            "key" => "nullable",
        ]);
        $program = Program::find($id);
        if($program===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if(Auth::user()->enrolled_programs->where("program_id",$program->id)->first()===NULL){
            abort(404);
        }
        else{
            $feedback = json_decode($program->feedback);
            if($request->key === NULL){
                $feedback[] = [
                    "stars"=>$request->stars,
                    "feedback"=>$request->feedback,
                    "user_id" => Auth::user()->id
                ];
            }
            else{
                $feedback[$request->key] = [
                    "stars"=>$request->stars,
                    "feedback"=>$request->feedback,
                    "user_id" => Auth::user()->id
                ];
            }
            $program->feedback = \json_encode($feedback);
            $program->save();
            $request->session()->flash('success', "Feedback submitted");
            return redirect()->back();
        }
    }
}
