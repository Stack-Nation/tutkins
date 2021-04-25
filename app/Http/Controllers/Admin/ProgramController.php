<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;

class ProgramController extends Controller
{
    public function index(){
        $programs = Program::latest()->paginate(15);
        return view("admin.programs")->with([
            "programs" => $programs
        ]);
    }
}
