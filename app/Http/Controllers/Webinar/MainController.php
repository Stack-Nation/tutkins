<?php

namespace App\Http\Controllers\Webinar;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Webinar;

class MainController extends Controller
{
    public function index(){
        $webinars = Webinar::whereNotNull("form")->latest()->paginate(16);
        return view("webinars.index")->with([
            "webinars" => $webinars
        ]);
    }
    public function view($id,$title){
        $webinar = Webinar::find($id);
        if($webinar===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if($title == md5($webinar->title)){
            $webinar->images = json_decode($webinar->images);
            return view("webinars.view")->with([
                "webinar"=>$webinar,
            ]);
        }
        else{
            abort(404);
        }
    }
}
