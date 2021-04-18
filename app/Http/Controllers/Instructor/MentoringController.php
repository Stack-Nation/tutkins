<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mentoring;
use App\Models\EnrolledMentoring;
use App\Models\Category;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\GlobalMail;
use App\Models\Notification;

class MentoringController extends Controller
{
    public function index(){
        $mentorings = Mentoring::where(["owner_id"=>Auth::user()->id])->latest()->paginate(15);
        return view("instructor.mentoring.index")->with([
            "mentorings"=>$mentorings
        ]);
    }
    public function create(){
        $cats = Category::latest()->get();
        return view("instructor.mentoring.create")->with([
            "cats"=>$cats
        ]);
    }
    public function store(Request $request){
        $this->validate($request,[
            "title"=>"required",
            "category"=>"required",
            "description"=>"required",
            "thumbnail"=>"required|image",
            "link"=>"required",
            "availability"=>"required",
            "times"=>"required",
            "price"=>"required",
            "duration"=>"required",
        ]);
        $mentoring = new Mentoring;
        $mentoring->title = $request->title;
        $mentoring->description = $request->description;
        $mentoring->category_id = $request->category;
        $mentoring->owner_id = Auth::user()->id;
        $mentoring->availability = $request->availability;
        $mentoring->times = json_encode($request->times);
        $mentoring->price = $request->price;
        $mentoring->duration = $request->duration;
        if($request->hasFile("thumbnail")){
            $tpath = "assets/mentorings/thumbnail/";
            $name = $_FILES["thumbnail"]["name"];
            $tmp = $_FILES["thumbnail"]["tmp_name"];
            $name = idate("U").$name;
            if(\move_uploaded_file($tmp,$tpath.$name)){
                $mentoring->thumbnail = $name;
            }
            else{
                $request->session()->flash('error', "There is some problem in uploading thumbnail");
                return redirect()->back();
            }
        }
        $mentoring->link = $request->link;
        $mentoring->save();

        // Mail
        $user = Auth::user();
        $sub = "Your mentoring program has been created successfully.";
        $message="<p>Dear ".$user->name.",</p><p>Your mentoring program ".$mentoring->title." is successfully created.</p>";
        $data = array('sub'=>$sub,'message'=>$message);
        Mail::to($user->email)->send(new GlobalMail($data));

        $notification = new Notification;
        $notification->user_id = $user->id;
        $notification->message = "Your mentoring program ".$mentoring->title." is successfully created";
        $notification->save();
        $request->session()->flash('success', "Mentoring program created. Create a questionair form");
        return redirect()->route('instructor.mentorings.form.create', ['id' => $mentoring->id]);
    }
    public function delete(Request $request){
        $this->validate($request,[
            "id"=>"required"
        ]);
        $mentoring = Mentoring::find($request->id);
        unlink("assets/mentorings/thumbnail/".$mentoring->thumbnail);
        EnrolledMentoring::where("mentoring_id",$mentoring->id)->delete();
        $mentoring->delete();
        $request->session()->flash('success', "Mentoring successfully deleted");
        return redirect()->back();
    }

    public function createForm($id){
        $mentoring = Mentoring::find($id);
        if($mentoring===NULL){
            abort(404);
        }
        if($mentoring->owner_id === Auth::user()->id){
            if($mentoring->form===NULL){
                return view("instructor.mentoring.form.create")->with([
                    "mentoring"=>$mentoring
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
    public function storeForm($id,Request $request){
        $this->validate($request,[
            "content"=>"required"
        ]);
        $mentoring = Mentoring::find($id);
        if($mentoring===NULL){
            abort(404);
        }
        if($mentoring->owner_id === Auth::user()->id){
            if($mentoring->form===NULL){
                $mentoring->form = $request->content;
                $mentoring->save();
                $request->session()->flash('success', "Questionair form created");
                return redirect()->route('instructor.mentorings');
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
