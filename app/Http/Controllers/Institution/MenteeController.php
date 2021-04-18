<?php

namespace App\Http\Controllers\Institution;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Hash;

class MenteeController extends Controller
{
    public function index(){
        $mentees = User::where(["inst_id"=>Auth::user()->id])->latest()->paginate(15);
        return view("institution.mentee.index")->with([
            "mentees"=>$mentees
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
            if($user->role!=="Mentee"){
                $request->session()->flash('success', "The email is already registered with an user who is not a mentee");
                return redirect()->back();
            }
        }
        else{
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = "Mentee";
        }
        $user->category = $request->category;
        $user->inst_id = Auth::user()->id;
        $user->save();
        $request->session()->flash('success', "Mentee successfully created");
        return redirect()->back();
    }
    public function createBulk(Request $request){
        $this->validate($request,[
            "mentees"=>"required|mimes:xls,xlsx"
        ]);
        $inputFileName = $_FILES["mentees"]["tmp_name"];
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
                    if($user->role!=="Mentee"){
                        continue;
                    }
                }
                else{
                    $user = new User;
                    $user->name = $datas[$i]["A"];
                    $user->email = $datas[$i]["B"];
                    $user->password = Hash::make($datas[$i]["C"]);
                    $user->role = "Mentee";
                }
                $user->category = $datas[$i]["D"];
                $user->inst_id = Auth::user()->id;
                $user->save();
            }
            $request->session()->flash('success', "Mentees added from the file");
            return redirect()->back();
        }
    }
    public function delete(Request $request){
        $this->validate($request,[
            "id"=>"required",
        ]);
        $user = User::find($request->id);
        if($user===NULL){
            $request->session()->flash('error', "The mentee does not exist");
            return redirect()->back();
        }
        else{
            if($user->inst_id!==Auth::user()->id){
                $request->session()->flash('error', "The mentee is not associated with your institution.");
                return redirect()->back();
            }
            else{
                $user->inst_id = NULL;
                $user->save();
                $request->session()->flash('success', "The mentee is removed from your institution");
                return redirect()->back();
            }
        }
    }
}
