<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mentoring;

class MentoringController extends Controller
{
    public function index(){
        $mentorings = Mentoring::latest()->paginate(15);
        return view("admin.mentorings")->with([
            "mentorings" => $mentorings
        ]);
    }
}
