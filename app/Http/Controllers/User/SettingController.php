<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;

class SettingController extends Controller
{
    public function settings(){
        return view("users.settings");
    }
    public function update(Request $request){
        $this->validate($request,[
            "current_password"=>"required|string|min:8",
            "password"=>"required|string|confirmed|min:8",
        ]);
        $user = Auth::user();
        if(Hash::check($request->current_password, $user->password)){
            $user->password = Hash::make($request->password);
            $request->session()->flash('success', "Password changed successfully");
            Auth::logout();
            return redirect()->back();
        }
        else{
            $request->session()->flash('error', "The current password is incorrect");
            return redirect()->back();
        }
    }
    public function notVerified(){
        return view("users.not-verified");
    }
    public function training(Request $request){
        $this->validate($request,[
            "title" => "required",
            "description" => "required",
            "document" => "required",
            "video" => "required",
        ]);
        $user = Auth::user();
        $trainings = \json_decode($user->training);
        if($request->hasFile("document")){
            $path = "assets/users/training/document/";
            $name = $_FILES["document"]["name"];
            $tmp_name = $_FILES["document"]["tmp_name"];
            $name = idate("U").$name;
            if(\move_uploaded_file($tmp_name,$path.$name)){
                $document = $name;
            }
            else{
                $request->session()->flash('error', "There is some error in uploading document");
                return redirect()->back();
            }
        }
        else{
            $request->session()->flash('error', "Document is required");
            return redirect()->back();
        }
        if($request->hasFile("video")){
            $path = "assets/users/training/video/";
            $name = $_FILES["video"]["name"];
            $tmp_name = $_FILES["video"]["tmp_name"];
            $name = idate("U").$name;
            if(\move_uploaded_file($tmp_name,$path.$name)){
                $video = $name;
            }
            else{
                $request->session()->flash('error', "There is some error in uploading video");
                return redirect()->back();
            }
        }
        else{
            $request->session()->flash('error', "Video is required");
            return redirect()->back();
        }
        
        $training = [
            "title" => $request->title,
            "description" => $request->description,
            "document" => $document,
            "video" => $video,
        ];
        $trainings[] = $training;
        $user->training = \json_encode($trainings);
        $user->save();
        $request->session()->flash('success', "Infomation saved");
        return redirect()->back();
    }
    public function parent(Request $request){
        $this->validate($request,[
            "name" => "required",
            "description" => "required",
            "dob" => "required",
            "occupation" => "required",
            "company" => "required",
            "aadhar" => "required",
        ]);
        $user = Auth::user();
        $parent_info = \json_decode($user->parent_info);
        if($parent_info!=NULL and count($parent_info)>=2){
            $request->session()->flash('warning', "No more than 2 entries allowed");
            return redirect()->back();
        }
        if($request->hasFile("aadhar")){
            $path = "assets/users/parent/";
            $name = $_FILES["aadhar"]["name"];
            $tmp_name = $_FILES["aadhar"]["tmp_name"];
            $name = idate("U").$name;
            if(\move_uploaded_file($tmp_name,$path.$name)){
                $parent = [
                    "name" => $request->name,
                    "description" => $request->description,
                    "dob" => $request->dob,
                    "occupation" => $request->occupation,
                    "company" => $request->company,
                    "aadhar" => $name,
                ];
                $parent_info[] = $parent;
                $user->parent_info = \json_encode($parent_info);
                $user->save();
                $request->session()->flash('success', "Infomation saved");
                return redirect()->back();
            }
            else{
                $request->session()->flash('error', "There is some error in uploading aadhar");
                return redirect()->back();
            }
        }
    }
}
