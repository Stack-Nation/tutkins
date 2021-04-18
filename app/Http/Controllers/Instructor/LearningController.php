<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LearningPath;
use App\Models\Course;
use App\Models\Mentoring;
use App\Models\TestGroup;
use Auth;

class LearningController extends Controller
{
    public function index(){
        $learnings = LearningPath::where(["owner_id"=>Auth::user()->id])->latest()->paginate(15);
        return view("instructor.learning.index")->with([
            "learnings"=>$learnings
        ]);
    }
    public function create(){
        $courses = Course::where(["instructor_id"=>Auth::user()->id])->latest()->get();
        $mentorings = Mentoring::where(["owner_id"=>Auth::user()->id])->latest()->get();
        $tests = TestGroup::where(["instructor_id"=>Auth::user()->id])->latest()->get();
        return view("instructor.learning.create")->with([
            "courses"=>$courses,
            "mentorings"=>$mentorings,
            "tests"=>$tests,
        ]);
    }
    public function store(Request $request){
        $this->validate($request,[
            "title"=>"required",
            "description"=>"required",
            "thumbnail"=>"required|image",
            "images"=>"required",
            "price"=>"required",
            "discount"=>"required",
            "courses"=>"required",
            "mentorings"=>"required",
            "tests"=>"required",
        ]);
        $learning = new LearningPath;
        $learning->title = $request->title;
        $learning->description = $request->description;
        $learning->owner_id = Auth::user()->id;
        $learning->price = $request->price;
        $learning->discount = $request->discount;
        $learning->courses = json_encode($request->courses);
        $learning->mentorings = json_encode($request->mentorings);
        $learning->tests = json_encode($request->tests);
        if($request->hasFile("thumbnail")){
            $tpath = "assets/learning_paths/thumbnail/";
            $name = $_FILES["thumbnail"]["name"];
            $tmp = $_FILES["thumbnail"]["tmp_name"];
            $name = idate("U").$name;
            if(\move_uploaded_file($tmp,$tpath.$name)){
                $learning->thumbnail = $name;
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
        $learning->images = \json_encode($images);
        $learning->save();
        $request->session()->flash('success', "Learning path created. Create a certificate");
        return redirect()->route('instructor.learnings.certificate.create', ['id' => $learning->id]);
    }
    public function delete(Request $request){
        $this->validate($request,[
            "id"=>"required"
        ]);
        $learning = LearningPath::find($request->id);
        unlink("assets/learning_paths/thumbnail/".$learning->thumbnail);
        $learning->delete();
        $request->session()->flash('success', "Learning path successfully deleted");
        return redirect()->back();
    }

    public function createCertificate($id){
        $learning = LearningPath::find($id);
        if($learning===NULL){
            abort(404);
        }
        if($learning->owner_id === Auth::user()->id){
            if($learning->certificate===NULL){
                return view("instructor.learning.certificate.create")->with([
                    "learning"=>$learning
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
    public function storeCertificate($id,Request $request){
        $this->validate($request,[
            "image"=>"required",
            "name"=>"required",
            "path_name"=>"required",
            "date"=>"required",
        ]);
        $learning = LearningPath::find($id);
        if($learning===NULL){
            abort(404);
        }
        if($learning->owner_id === Auth::user()->id){
            if($learning->certificate===NULL){
                $certificate = [
                    "image" => $request->image,
                    "name" => $request->name,
                    "path_name" => $request->path_name,
                    "date" => $request->date,
                ];
                $learning->certificate = \json_encode($certificate);
                $learning->save();
                $request->session()->flash('success', "Certificate created");
                return redirect()->route('instructor.learnings');
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
