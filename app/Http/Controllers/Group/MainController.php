<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\GroupPost;
use Auth;

class MainController extends Controller
{
    public function index(){
        $groups = Group::where(["course_id"=>NULL])->latest()->paginate(16);
        return view("groups.index")->with([
            "groups" => $groups
        ]);
    }
    public function view($id,$name){
        $group = Group::find($id);
        if($group===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if($name == md5($group->name)){
            $posts = GroupPost::where(["group_id"=>$group->id,"approved"=>1])->latest()->paginate(10);
            return view("groups.view")->with([
                "group"=>$group,
                "posts"=>$posts,
            ]);
        }
        else{
            abort(404);
        }
    }
    public function changeCover($id,Request $request){
        $this->validate($request,[
            "cover"=>"required|image"
        ]);
        $group = Group::find($id);
        if($group===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if($group->owner_id == Auth::user()->id){
            $path = "assets/groups/cover/";
            $name = $_FILES["cover"]["name"];
            $tmp = $_FILES["cover"]["tmp_name"];
            $name = idate("U").$name;
            if(\move_uploaded_file($tmp,$path.$name)){
                if($group->cover!==NULL and $group->cover!=$name){
                    unlink($path.$group->cover);
                }
                $group->cover = $name;
                $group->save();
                $request->session()->flash('success', "Cover updated");
                return redirect()->back();
            }
            else{
                $request->session()->flash('error', "There is some problem in uploading the cover");
                return redirect()->back();
            }
        }
        else{
            abort(404);
        }
    }
    public function changePhoto($id,Request $request){
        $this->validate($request,[
            "photo"=>"required|image"
        ]);
        $group = Group::find($id);
        if($group===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if($group->owner_id == Auth::user()->id){
            $path = "assets/groups/photo/";
            $name = $_FILES["photo"]["name"];
            $tmp = $_FILES["photo"]["tmp_name"];
            $name = idate("U").$name;
            if(\move_uploaded_file($tmp,$path.$name)){
                if($group->photo!==NULL and $group->photo!=$name){
                    unlink($path.$group->photo);
                }
                $group->photo = $name;
                $group->save();
                $request->session()->flash('success', "Photo updated");
                return redirect()->back();
            }
            else{
                $request->session()->flash('error', "There is some problem in uploading the photo");
                return redirect()->back();
            }
        }
        else{
            abort(404);
        }
    }
    public function changeDescription($id,Request $request){
        $this->validate($request,[
            "description"=>"required"
        ]);
        $group = Group::find($id);
        if($group===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if($group->owner_id == Auth::user()->id){
            $group->description = $request->description;
            $group->save();
            $request->session()->flash('success', "Description updated");
            return redirect()->back();
        }
        else{
            abort(404);
        }
    }
    public function changeName($id,Request $request){
        $this->validate($request,[
            "name"=>"required"
        ]);
        $group = Group::find($id);
        if($group===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if($group->owner_id == Auth::user()->id){
            $group->name = $request->name;
            $group->save();
            $request->session()->flash('success', "Name updated");
            return redirect()->route("groups.view",[$group->id,md5($group->name)]);
        }
        else{
            abort(404);
        }
    }
    public function join($id,Request $request){
        $group = Group::find($id);
        if($group===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if($group->owner_id !== Auth::user()->id){
            if(GroupMember::where(["group_id"=>$group->id,"user_id"=>Auth::user()->id])->exists()){
                GroupMember::where(["group_id"=>$group->id,"user_id"=>Auth::user()->id])->delete();
                $request->session()->flash('success', "Group left");
                return redirect()->back();
            }
            else{
                $groupm = new GroupMember;
                $groupm->group_id = $group->id;
                $groupm->user_id = Auth::user()->id;
                if($group->join_approval===1){
                    $groupm->approved = 0;
                    $request->session()->flash('success', "Group joining request sent");
                }
                else{
                    $groupm->approved = 1;
                    $request->session()->flash('success', "Group joined");
                }
                $groupm->save();
                return redirect()->back();
            }
        }
        else{
            abort(404);
        }
    }
}
