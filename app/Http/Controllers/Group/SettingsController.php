<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\GroupPost;
use Auth;

class SettingsController extends Controller
{
    public function settings($id){
        $group = Group::find($id);
        if($group===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if($group->owner_id == Auth::user()->id){
            return view("groups.settings")->with([
                "group"=>$group
            ]);
        }
        else{
            abort(404);
        }
    }
    public function settingsChange($id,Request $request){
        $this->validate($request,[
            "settings"=>"nullable"
        ]);
        $group = Group::find($id);
        if($group===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if($group->owner_id == Auth::user()->id){
            $group->post_approval = 0;
            $group->join_approval = 0;
            $group->private = 0;
            if($request->settings){
                foreach($request->settings as $settings){
                    if($settings == "post_app"){
                        $group->post_approval = 1;
                    }
                    if($settings == "join_app"){
                        $group->join_approval = 1;
                    }
                    if($settings == "private"){
                        $group->private = 1;
                    }
                }
            }
            $group->save();
            $request->session()->flash('success', "Settings updated");
            return redirect()->back();
        }
        else{
            abort(404);
        }
    }
    public function joinRequests($id){
        $group = Group::find($id);
        if($group===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if($group->owner_id == Auth::user()->id){
            $members = GroupMember::where(["group_id"=>$group->id,"approved"=>0])->latest()->paginate(15);
            return view("groups.join-requests")->with([
                "members"=>$members
            ]);
        }
        else{
            abort(404);
        }
    }
    public function joinRequestsApprove($id,Request $request){
        $this->validate($request,[
            "id"=>"required"
        ]);
        $group = Group::find($id);
        if($group===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if($group->owner_id == Auth::user()->id){
            $member = GroupMember::find($request->id);
            $member->approved = 1;
            $member->save();
            $request->session()->flash('success', "Member Approved");
            return redirect()->back();
        }
        else{
            abort(404);
        }
    }
    public function joinRequestsReject($id,Request $request){
        $this->validate($request,[
            "id"=>"required"
        ]);
        $group = Group::find($id);
        if($group===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if($group->owner_id == Auth::user()->id){
            $member = GroupMember::find($request->id)->delete();
            $request->session()->flash('success', "Member Rejected");
            return redirect()->back();
        }
        else{
            abort(404);
        }
    }
    public function del(Request $request){
        $this->validate($request,[
            "id"=>"required"
        ]);
        $group = Group::find($request->id);
        if($group===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if($group->owner_id === Auth::user()->id and $group->course_id===NULL){
            unlink("assets/groups/photo/".$group->photo);
            if($group->cover!==NULL){
                unlink("assets/groups/cover/".$group->cover);
            }
            GroupMember::where("group_id",$group->id)->delete();
            $group->delete();
            $request->session()->flash('success', "Group Deleted");
            return redirect()->route("groups.index");
        }
        else{
            abort(404);
        }
    }
    public function postApproval($id){
        $group = Group::find($id);
        if($group===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if($group->owner_id == Auth::user()->id){
            $posts = GroupPost::where(["group_id"=>$group->id,"approved"=>0])->latest()->paginate(10);
            return view("groups.post-approval")->with([
                "posts"=>$posts
            ]);
        }
        else{
            abort(404);
        }
    }
    public function postApprovalApprove($id,Request $request){
        $this->validate($request,[
            "id"=>"required"
        ]);
        $group = Group::find($id);
        if($group===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if($group->owner_id == Auth::user()->id){
            $member = GroupPost::find($request->id);
            $member->approved = 1;
            $member->save();
            $request->session()->flash('success', "Post Approved");
            return redirect()->back();
        }
        else{
            abort(404);
        }
    }
    public function postApprovalReject($id,Request $request){
        $this->validate($request,[
            "id"=>"required"
        ]);
        $group = Group::find($id);
        if($group===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if($group->owner_id == Auth::user()->id){
            $member = GroupPost::find($request->id)->delete();
            $request->session()->flash('success', "Post Rejected");
            return redirect()->back();
        }
        else{
            abort(404);
        }
    }
}
