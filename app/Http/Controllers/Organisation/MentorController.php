<?php

namespace App\Http\Controllers\Organisation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Hash;

class MentorController extends Controller
{
    public function index(){
        $mentors = User::where(["inst_id"=>Auth::user()->id,"role"=>"Mentor"])->latest()->paginate(15);
        return view("organisation.mentor.index")->with([
            "mentors"=>$mentors
        ]);
    }
    public function create(Request $request){
        $this->validate($request,[
            "name"=>"required|string",
            "email"=>"required|string|email",
            "password"=>"required|string|confirmed|min:8",
            "category"=>"required",
        ]);
        $user = User::where(["email"=>$request->email])->first();
        if($user!==NULL){
            if($user->role!=="Mentor"){
                $request->session()->flash('success', "The email is already registered with an user who is not a mentor");
                return redirect()->back();
            }
        }
        else{
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = "Mentor";
        }
        $user->category = $request->category;
        $user->inst_id = Auth::user()->id;
        $user->save();
        $request->session()->flash('success', "Mentor successfully created");
        return redirect()->back();
    }
    public function createBulk(Request $request){
        $this->validate($request,[
            "mentors"=>"required|mimes:xls,xlsx"
        ]);
        $inputFileName = $_FILES["mentors"]["tmp_name"];
        /**  Identify the type of $inputFileName  **/
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
        /**  Create a new Reader of the type that has been identified  **/
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        /**  Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = $reader->load($inputFileName);
        $datas = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $keys = $datas[1];
        if(!in_array("name",$keys) or !in_array("email",$keys) or !in_array("password",$keys) or !in_array("category",$keys)){
            $request->session()->flash('error', "The column must have name, email, password and category in case-senstive and same sequence");
            return redirect()->back();
        }
        else{
            for($i=2;$i<count($datas)+1;$i++){
                $user = User::where(["email"=>$datas[$i]["B"]])->first();
                if($user!==NULL){
                    if($user->role!=="Mentor"){
                        continue;
                    }
                }
                else{
                    $user = new User;
                    $user->name = $datas[$i]["A"];
                    $user->email = $datas[$i]["B"];
                    $user->password = Hash::make($datas[$i]["C"]);
                    $user->role = "Mentor";
                }
                $user->category = $datas[$i]["D"];
                $user->inst_id = Auth::user()->id;
                $user->save();
            }
            $request->session()->flash('success', "Mentors added from the file");
            return redirect()->back();
        }
    }
    public function delete(Request $request){
        $this->validate($request,[
            "id"=>"required",
        ]);
        $user = User::find($request->id);
        if($user===NULL){
            $request->session()->flash('error', "The mentor does not exist");
            return redirect()->back();
        }
        else{
            if($user->inst_id!==Auth::user()->id){
                $request->session()->flash('error', "The mentor is not associated with your organisation.");
                return redirect()->back();
            }
            else{
                $user->inst_id = NULL;
                $user->save();
                $request->session()->flash('success', "The mentor is removed from your organisation");
                return redirect()->back();
            }
        }
    }
}
