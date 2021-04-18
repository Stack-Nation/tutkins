<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\ExamCategory;
use App\Models\ExamQuestion;
use App\Models\Test;
use App\Models\TestGroup;
use Auth;

class TestsController extends Controller
{
    public function index(){
        $tests = Test::where("instructor_id",Auth::user()->id)->latest()->paginate(10);
        return view("instructor.tests.test.index")->with([
            "tests"=>$tests,
            "type"=>"tests",
        ]);
    }
    public function createTest(){
        $subjects = Subject::where("instructor_id",Auth::user()->id)->latest()->get();
        $categories = ExamCategory::where("instructor_id",Auth::user()->id)->latest()->get();
        $questions = ExamQuestion::where("instructor_id",Auth::user()->id)->latest()->get();
        return view("instructor.tests.test.create")->with([
            "subjects"=>$subjects,
            "categories"=>$categories,
            "questions"=>$questions,
        ]);
    }
    public function storeTest(Request $request){
        $this->validate($request,[
            "title"=>"required",
            "description"=>"required",
            "image"=>"required|image",
            "category"=>"required",
            "subject"=>"required",
            "question"=>"required",
        ]);
        $test = new Test;
        $test->title = $request->title;
        $test->description = $request->description;
        $test->instructor_id = Auth::user()->id;
        $test->category_id = $request->category;
        $test->subject_id = $request->subject;
        $test->questions = json_encode($request->question);
        if($request->hasFile("image")){
            $image = $_FILES["image"]["name"];
            $tmp = $_FILES["image"]["tmp_name"];
            $path = "assets/tests/image/";
            $image = idate("U").$image;
            if(\move_uploaded_file($tmp,$path.$image)){
                $test->image = $image;
            }
            else{
                $request->session()->flash('error', "Some problem occured while uploading the image");
                return redirect()->back();
            }
        }
        $test->save();
        $request->session()->flash('success', "Test created");
        return redirect()->back();
    }
    public function deleteTest(Request $request){
        $this->validate($request,[
            "id"=>"required"
        ]);
        $test = Test::find($request->id);
        unlink("assets/tests/image/".$test->image);
        $test->delete();
        $request->session()->flash('success', "Test successfully deleted");
        return redirect()->back();
    }

    public function groups(){
        $groups = TestGroup::where("instructor_id",Auth::user()->id)->latest()->paginate(10);
        return view("instructor.tests.group.index")->with([
            "groups"=>$groups,
            "type"=>"groups",
        ]);
    }
    public function createTestGroup(){
        $tests = Test::where("instructor_id",Auth::user()->id)->latest()->get();
        return view("instructor.tests.group.create")->with([
            "tests"=>$tests
        ]);
    }
    public function storeTestGroup(Request $request){
        $this->validate($request,[
            "title"=>"required",
            "description"=>"required",
            "image"=>"required|image",
            "test"=>"required",
        ]);
        $test = new TestGroup;
        $test->title = $request->title;
        $test->description = $request->description;
        $test->instructor_id = Auth::user()->id;
        $test->tests = json_encode($request->test);
        if($request->hasFile("image")){
            $image = $_FILES["image"]["name"];
            $tmp = $_FILES["image"]["tmp_name"];
            $path = "assets/test_groups/image/";
            $image = idate("U").$image;
            if(\move_uploaded_file($tmp,$path.$image)){
                $test->image = $image;
            }
            else{
                $request->session()->flash('error', "Some problem occured while uploading the image");
                return redirect()->back();
            }
        }
        $test->save();
        $request->session()->flash('success', "Test group created");
        return redirect()->back();
    }
    public function deleteTestGroup(Request $request){
        $this->validate($request,[
            "id"=>"required"
        ]);
        $test = TestGroup::find($request->id);
        unlink("assets/test_groups/image/".$test->image);
        $test->delete();
        $request->session()->flash('success', "Test group successfully deleted");
        return redirect()->back();
    }
}
