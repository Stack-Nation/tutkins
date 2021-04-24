<?php

namespace App\Http\Controllers\Kid;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EnrolledProgram;
use Auth;

class ProgramController extends Controller
{
    public function index(){
        $programs = EnrolledProgram::where("user_id",Auth::user()->id)->latest()->paginate(15);
        return view("kid.programs")->with([
            "programs" => $programs
        ]);
    }
}
