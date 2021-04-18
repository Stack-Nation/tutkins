<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\ExamCategory;
use App\Models\ExamQuestion;
use Auth;

class ExamController extends Controller
{
    public function index(){
        $subjects = Subject::where("instructor_id",Auth::user()->id)->latest()->paginate(10);
        return view("instructor.exams.subject.index")->with([
            "subjects"=>$subjects,
            "type"=>"subjects",
        ]);
    }
    public function createSubject(){
        return view("instructor.exams.subject.create");
    }
    public function storeSubject(Request $request){
        $this->validate($request,[
            "title"=>"required|string",
            "description"=>"required|string",
            "image"=>"required|image",
        ]);
        $subject = new Subject;
        $subject->title = $request->title;
        $subject->description = $request->description;
        $subject->instructor_id = Auth::user()->id;
        if($request->hasFile("image")){
            $image = $_FILES["image"]["name"];
            $tmp = $_FILES["image"]["tmp_name"];
            $path = "assets/subjects/image/";
            $image = idate("U").$image;
            if(\move_uploaded_file($tmp,$path.$image)){
                $subject->image = $image;
            }
            else{
                $request->session()->flash('error', "Some problem occured while uploading the image");
                return redirect()->back();
            }
        }
        $subject->save();
        $request->session()->flash('success', "Subject successfully created");
        return redirect()->back();
    }
    public function deleteSubject(Request $request){
        $this->validate($request,[
            "id"=>"required"
        ]);
        $subject = Subject::find($request->id);
        unlink("assets/subjects/image/".$subject->image);
        $subject->delete();
        $request->session()->flash('success', "Subject successfully deleted");
        return redirect()->back();
    }

    public function categories(){
        $categories = ExamCategory::where("instructor_id",Auth::user()->id)->latest()->paginate(10);
        return view("instructor.exams.category.index")->with([
            "categories"=>$categories,
            "type"=>"categories",
        ]);
    }
    public function createCategory(){
        return view("instructor.exams.category.create");
    }
    public function storeCategory(Request $request){
        $this->validate($request,[
            "name"=>"required|string",
            "image"=>"required|image",
        ]);
        $category = new ExamCategory;
        $category->name = $request->name;
        $category->instructor_id = Auth::user()->id;
        if($request->hasFile("image")){
            $image = $_FILES["image"]["name"];
            $tmp = $_FILES["image"]["tmp_name"];
            $path = "assets/exam_categories/image/";
            $image = idate("U").$image;
            if(\move_uploaded_file($tmp,$path.$image)){
                $category->image = $image;
            }
            else{
                $request->session()->flash('error', "Some problem occured while uploading the image");
                return redirect()->back();
            }
        }
        $category->save();
        $request->session()->flash('success', "Exam category successfully created");
        return redirect()->back();
    }
    public function deleteCategory(Request $request){
        $this->validate($request,[
            "id"=>"required"
        ]);
        $category = ExamCategory::find($request->id);
        unlink("assets/exam_categories/image/".$category->image);
        $category->delete();
        $request->session()->flash('success', "Category successfully deleted");
        return redirect()->back();
    }

    public function questions(){
        $questions = ExamQuestion::where("instructor_id",Auth::user()->id)->latest()->paginate(10);
        return view("instructor.exams.question.index")->with([
            "questions"=>$questions,
            "type"=>"questions",
        ]);
    }
    public function createQuestion(){
        return view("instructor.exams.question.create");
    }
    public function storeQuestion(Request $request){
        $this->validate($request,[
            "title"=>"required|string",
            "type"=>"required|string",
            "isnegmark"=>"required|string",
            "marks"=>"required",
            "option1"=>"required",
            "option2"=>"required",
            "option3"=>"required",
            "option4"=>"required",
            "iscorrect1"=>"required",
            "iscorrect2"=>"required",
            "iscorrect3"=>"required",
            "iscorrect4"=>"required",
            "explaination1"=>"required",
            "explaination2"=>"required",
            "explaination3"=>"required",
            "explaination4"=>"required",
        ]);
        $question = new ExamQuestion;
        $question->title = $request->title;
        $question->instructor_id = Auth::user()->id;
        $question->type = $request->type;
        $question->marking = $request->marks;
        if($request->isnegmark=="yes"){
            $this->validate($request,[
                "nmarks"=>"required",
            ]);
            $question->nmarking = $request->nmarks;
        }
        $answers = [
            [
                "option"=>$request->option1,
                "iscorrect"=>$request->iscorrect1,
                "explaination"=>$request->explaination1,
            ],
            [
                "option"=>$request->option2,
                "iscorrect"=>$request->iscorrect2,
                "explaination"=>$request->explaination2,
            ],
            [
                "option"=>$request->option3,
                "iscorrect"=>$request->iscorrect3,
                "explaination"=>$request->explaination3,
            ],
            [
                "option"=>$request->option4,
                "iscorrect"=>$request->iscorrect4,
                "explaination"=>$request->explaination4,
            ],
        ];
        $question->answers = json_encode($answers);
        $question->save();
        $request->session()->flash('success', "Question successfully created");
        return redirect()->back();
    }
    public function deleteQuestion(Request $request){
        $this->validate($request,[
            "id"=>"required"
        ]);
        $question = ExamQuestion::find($request->id);
        $question->delete();
        $request->session()->flash('success', "Question successfully deleted");
        return redirect()->back();
    }
}
