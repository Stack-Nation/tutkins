<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Webinar;
use App\Models\EnrolledWebinar;
use App\Models\Category;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\GlobalMail;
use App\Models\Notification;

class WebinarController extends Controller
{
    public function index(){
        $webinars = Webinar::where(["owner_id"=>Auth::user()->id])->latest()->paginate(15);
        return view("instructor.webinar.index")->with([
            "webinars"=>$webinars
        ]);
    }
    public function create(){
        $cats = Category::latest()->get();
        return view("instructor.webinar.create")->with([
            "cats"=>$cats
        ]);
    }
    public function store(Request $request){
        $this->validate($request,[
            "title"=>"required",
            "category"=>"required",
            "description"=>"required",
            "thumbnail"=>"required|image",
            "images"=>"required",
            "date"=>"required",
            "time"=>"required",
            "price"=>"required",
            "duration"=>"required",
            "discount"=>"required",
        ]);
        $webinar = new Webinar;
        $webinar->title = $request->title;
        $webinar->description = $request->description;
        $webinar->category_id = $request->category;
        $webinar->owner_id = Auth::user()->id;
        $webinar->date = $request->date;
        $webinar->time = $request->time;
        $webinar->price = $request->price;
        $webinar->duration = $request->duration;
        $webinar->discount = $request->discount;
        if($request->hasFile("thumbnail")){
            $tpath = "assets/webinars/thumbnail/";
            $name = $_FILES["thumbnail"]["name"];
            $tmp = $_FILES["thumbnail"]["tmp_name"];
            $name = idate("U").$name;
            if(\move_uploaded_file($tmp,$tpath.$name)){
                $webinar->thumbnail = $name;
            }
            else{
                $request->session()->flash('error', "There is some problem in uploading thumbnail");
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
        $webinar->images = \json_encode($images);
        $webinar->save();

        // Mail
        $user = Auth::user();
        $sub = "Your webinar has been created successfully.";
        $message="<p>Dear ".$user->name.",</p><p>Your webinar ".$webinar->title." is successfully created.</p>";
        $data = array('sub'=>$sub,'message'=>$message);
        Mail::to($user->email)->send(new GlobalMail($data));

        $notification = new Notification;
        $notification->user_id = $user->id;
        $notification->message = "Your webinar ".$webinar->title." is successfully created";
        $notification->save();
        $request->session()->flash('success', "Webinar created. Create a questionair form");
        return redirect()->route('instructor.webinars.form.create', ['id' => $webinar->id]);
    }
    public function delete(Request $request){
        $this->validate($request,[
            "id"=>"required"
        ]);
        $webinar = Webinar::find($request->id);
        unlink("assets/webinars/thumbnail/".$webinar->thumbnail);
        EnrolledWebinar::where("webinar_id",$webinar->id)->delete();
        $webinar->delete();
        $request->session()->flash('success', "Webinar successfully deleted");
        return redirect()->back();
    }

    public function createForm($id){
        $webinar = Webinar::find($id);
        if($webinar===NULL){
            abort(404);
        }
        if($webinar->owner_id === Auth::user()->id){
            if($webinar->form===NULL){
                return view("instructor.webinar.form.create")->with([
                    "webinar"=>$webinar
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
        $webinar = Webinar::find($id);
        if($webinar===NULL){
            abort(404);
        }
        if($webinar->owner_id === Auth::user()->id){
            if($webinar->form===NULL){
                $webinar->form = $request->content;
                $webinar->save();
                $request->session()->flash('success', "Questionair form created");
                return redirect()->route('instructor.webinars');
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
