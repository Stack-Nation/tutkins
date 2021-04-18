<?php

namespace App\Http\Controllers\Mentoring;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mentoring;

class MainController extends Controller
{
    public function index(){
        $mentorings = Mentoring::whereNotNull("form")->latest()->paginate(16);
        return view("mentorings.index")->with([
            "mentorings" => $mentorings
        ]);
    }
    public function view($id,$title){
        $mentoring = Mentoring::find($id);
        if($mentoring===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if($title == md5($mentoring->title)){
            $mentoring->images = json_decode($mentoring->images);
            $mentoring->availability = json_decode($mentoring->availability);
            return view("mentorings.view")->with([
                "mentoring"=>$mentoring,
            ]);
        }
        else{
            abort(404);
        }
    }
}
