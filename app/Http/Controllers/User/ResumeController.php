<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class ResumeController extends Controller
{
    public function index(){
        $user = Auth::user();
        $user->experiences = \json_decode($user->experiences);
        $user->skills = \json_decode($user->skills);
        $user->projects = \json_decode($user->projects);
        $user->achievements = \json_decode($user->achievements);
        $user->social = (array)\json_decode($user->social);
        return view("users.resume.index")->with([
            "user" => $user
        ]);
    }
    public function experience(Request $request){
        $this->validate($request,[
            "company" => "required",
            "description" => "required",
            "position" => "required",
            "start" => "required",
            "end" => "required",
        ]);
        $user = Auth::user();
        $user->experiences = \json_decode($user->experiences);
        $experiences = $user->experiences;
        $experience = [
            "company" => $request->company,
            "description" => $request->description,
            "position" => $request->position,
            "start" => $request->start,
            "end" => $request->end,
        ];
        $experiences[] = $experience;
        $user->experiences = $experiences;
        $user->save();
        $request->session()->flash('success', "Experience Added");
        return redirect()->back();
    }
    public function skill(Request $request){
        $this->validate($request,[
            "name" => "required",
            "score" => "required",
        ]);
        $user = Auth::user();
        $user->skills = \json_decode($user->skills);
        $skills = $user->skills;
        $skill = [
            "name" => $request->name,
            "score" => $request->score,
        ];
        $skills[] = $skill;
        $user->skills = $skills;
        $user->save();
        $request->session()->flash('success', "Skill Added");
        return redirect()->back();
    }
    public function project(Request $request){
        $this->validate($request,[
            "name" => "required",
            "description" => "required",
            "start" => "required",
            "end" => "required",
        ]);
        $user = Auth::user();
        $user->projects = \json_decode($user->projects);
        $projects = $user->projects;
        $project = [
            "name" => $request->name,
            "description" => $request->description,
            "start" => $request->start,
            "end" => $request->end,
        ];
        $projects[] = $project;
        $user->projects = $projects;
        $user->save();
        $request->session()->flash('success', "Project Added");
        return redirect()->back();
    }
    public function achievement(Request $request){
        $this->validate($request,[
            "title" => "required",
            "description" => "required",
        ]);
        $user = Auth::user();
        $user->achievements = \json_decode($user->achievements);
        $achievements = $user->achievements;
        $achievement = [
            "title" => $request->title,
            "description" => $request->description,
        ];
        $achievements[] = $achievement;
        $user->achievements = $achievements;
        $user->save();
        $request->session()->flash('success', "Achievement Added");
        return redirect()->back();
    }
    public function social(Request $request){
        $this->validate($request,[
            "facebook" => "nullable",
            "twitter" => "nullable",
            "instagram" => "nullable",
            "linkedin" => "nullable",
            "github" => "nullable",
            "youtube" => "nullable",
            "website" => "nullable",
        ]);
        $user = Auth::user();
        $user->social = \json_decode($user->social);
        $social = [
            "facebook" => [
                "icon" => "fab fa-facebook",
                "link" => $request->facebook
            ],
            "twitter" => [
                "icon" => "fab fa-twitter",
                "link" => $request->twitter
            ],
            "instagram" => [
                "icon" => "fab fa-instagram",
                "link" => $request->instagram
            ],
            "linkedin" => [
                "icon" => "fab fa-linkedin",
                "link" => $request->linkedin
            ],
            "github" => [
                "icon" => "fab fa-github",
                "link" => $request->github
            ],
            "youtube" => [
                "icon" => "fab fa-youtube",
                "link" => $request->youtube
            ],
            "website" => [
                "icon" => "fa fa-globe",
                "link" => $request->website
            ],
        ];
        $user->social = $social;
        $user->save();
        $request->session()->flash('success', "Social Updated");
        return redirect()->back();
    }
    public function view($id,$name){
        $user = User::find($id);
        if($user===NULL){
            abort(404);
        }
        else{
            if($name == md5($user->name)){
                $user->experiences = \json_decode($user->experiences);
                $user->skills = \json_decode($user->skills);
                $user->projects = \json_decode($user->projects);
                $user->achievements = \json_decode($user->achievements);
                $user->social = (array)\json_decode($user->social);
                return view("users.resume.view")->with([
                    "user" => $user
                ]);
            }
            else{
                abort(404);
            }
        }
    }
}
