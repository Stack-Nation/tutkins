<?php

namespace App\Http\Controllers\Program;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use Auth;

class MainController extends Controller
{
    public function index(){
        $programs = Program::latest()->paginate(15);
        return view("programs.index")->with([
            "programs" => $programs
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
