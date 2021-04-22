<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Category;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\GlobalMail;
use App\Models\Notification;

class ProgramController extends Controller
{
    public function index(){
        $programs = Program::where("trainer_id",Auth::user()->id)->latest()->paginate(15);
        return view("trainer.program.index")->with([
            "programs" => $programs
        ]);
    }
    public function create(){
        $categories = Category::latest()->get();
        return view("trainer.program.create")->with([
            "categories" => $categories
        ]);
    }
    public function store(Request $request){
        $this->validate($request,[
            "title"=>"required",
            "category"=>"required",
            "description"=>"required",
            "instructions"=>"required",
            "mode"=>"required",
            "classes"=>"required",
            "link"=>"nullable",
            "thumbnail"=>"required|image",
            "images"=>"required",
            "dates"=>"required",
            "times"=>"required",
            "price"=>"required",
            "trial_price"=>"required",
            "duration"=>"required",
            "video"=>"required",
        ]);
        $program = new Program;
        $program->title = $request->title;
        $program->description = $request->description;
        $program->instructions = $request->instructions;
        $program->mode = $request->mode;
        $program->classes = $request->classes;
        $program->link = $request->link;
        $program->category_id = $request->category;
        $program->trainer_id = Auth::user()->id;
        $program->dates = json_encode($request->dates);
        $program->times = json_encode($request->times);
        $program->price = $request->price;
        $program->trial_price = $request->trial_price;
        $program->duration = $request->duration;
        if($request->hasFile("thumbnail")){
            $tpath = "assets/programs/thumbnail/";
            $name = $_FILES["thumbnail"]["name"];
            $tmp = $_FILES["thumbnail"]["tmp_name"];
            $name = idate("U").$name;
            if(\move_uploaded_file($tmp,$tpath.$name)){
                $program->thumbnail = $name;
            }
            else{
                $request->session()->flash('error', "There is some problem in uploading thumbnail");
                return redirect()->back();
            }
        }
        if($request->hasFile("video")){
            $tpath = "assets/programs/video/";
            $name = $_FILES["video"]["name"];
            $tmp = $_FILES["video"]["tmp_name"];
            $name = idate("U").$name;
            if(\move_uploaded_file($tmp,$tpath.$name)){
                $program->video = $name;
            }
            else{
                $request->session()->flash('error', "There is some problem in uploading video");
                return redirect()->back();
            }
        }
        $images = [];
        foreach($_FILES["images"]["tmp_name"] as $key => $img){
            $ext = explode(".",$_FILES["images"]["name"][$key])[1];
            $name = \chunk_split(\base64_encode(\file_get_contents($img)));
            $name = "data:image/".$ext.";base64,".$name;
            $images[] = $name;
        }
        $program->images = \json_encode($images);
        $program->save();

        // Mail
        $user = Auth::user();
        $sub = "Your program has been created successfully.";
        $message="<p>Dear ".$user->name.",</p><p>Your program ".$program->title." is successfully created.</p>";
        $data = array('sub'=>$sub,'message'=>$message);
        Mail::to($user->email)->send(new GlobalMail($data));

        $notification = new Notification;
        $notification->user_id = $user->id;
        $notification->message = "Your program ".$program->title." is successfully created";
        $notification->save();
        $request->session()->flash('success', "Program created.");
        return redirect()->back();
    }
    public function edit($id){
        $program = Program::find($id);
        if($program===NULL){
            abort(404);
        }
        else{
            if($program->trainer_id!==Auth::user()->id){
                abort(404);
            }
            else{
                $categories = Category::latest()->get();
                return view("trainer.program.edit")->with([
                    "program" => $program,
                    "categories" => $categories,
                ]);
            }
        }
    }
    public function update($id,Request $request){
        $this->validate($request,[
            "title"=>"required",
            "category"=>"required",
            "description"=>"required",
            "instructions"=>"required",
            "mode"=>"required",
            "classes"=>"required",
            "link"=>"nullable",
            "price"=>"required",
            "trial_price"=>"required",
            "duration"=>"required",
        ]);
        $program = Program::find($id);
        if($program===NULL){
            abort(404);
        }
        else{
            if($program->trainer_id!==Auth::user()->id){
                abort(404);
            }
            else{
                $program->title = $request->title;
                $program->description = $request->description;
                $program->instructions = $request->instructions;
                $program->mode = $request->mode;
                $program->classes = $request->classes;
                $program->link = $request->link;
                $program->category_id = $request->category;
                $program->price = $request->price;
                $program->trial_price = $request->trial_price;
                $program->duration = $request->duration;
                $program->save();
        
                // Mail
                $user = Auth::user();
                $sub = "Your program has been updated successfully.";
                $message="<p>Dear ".$user->name.",</p><p>Your program ".$program->title." is successfully updated.</p>";
                $data = array('sub'=>$sub,'message'=>$message);
                Mail::to($user->email)->send(new GlobalMail($data));
        
                $notification = new Notification;
                $notification->user_id = $user->id;
                $notification->message = "Your program ".$program->title." is successfully updated";
                $notification->save();
                $request->session()->flash('success', "Program created.");
                return redirect()->back();
            }
        }
    }
    public function delete(Request $request){
        $this->validate($request,[
            "id"=>"required"
        ]);
        $program = Program::find($request->id);
        if($program===NULL){
            abort(404);
        }
        else{
            if($program->trainer_id!==Auth::user()->id){
                abort(404);
            }
            else{
                unlink("assets/programs/thumbnail/".$program->thumbnail);
                unlink("assets/programs/video/".$program->video);
                // EnrolledProgram::where("program_id",$program->id)->delete();
                $program->delete();
                $request->session()->flash('success', "Program successfully deleted");
                return redirect()->back();
            }
        }
    }
}
