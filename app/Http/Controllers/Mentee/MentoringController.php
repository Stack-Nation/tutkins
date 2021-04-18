<?php

namespace App\Http\Controllers\Mentee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Mentoring;
use App\Models\EnrolledMentoring;

class MentoringController extends Controller
{
    public function index(){
        $mentorings = EnrolledMentoring::where(["user_id"=>Auth::user()->id])->latest()->paginate(10);
        return view("mentee.mentoring.index")->with([
            "mentorings"=>$mentorings
        ]);
    }
}
