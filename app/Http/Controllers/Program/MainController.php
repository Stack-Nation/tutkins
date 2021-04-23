<?php

namespace App\Http\Controllers\Program;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;

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
}
