<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\GroupMember;
use App\Models\GroupPost;
use Auth;

class PostController extends Controller
{
    public function create($id,Request $request){
        $this->validate($request,[
            "post"=>"required"
        ]);
        $group = Group::find($id);
        if($group===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if(GroupMember::where(["group_id"=>$group->id,"user_id"=>Auth::user()->id,"approved"=>1])->exists()){
            $post = new GroupPost;
            if($group->post_approval===1 and Auth::user()->id!==$group->owner_id){
                $post->approved = 0;
            }
            else{
                $post->approved = 1;
            }
            $post->content = $request->post;
            $post->user_id = Auth::user()->id;
            $post->group_id = $group->id;
            $post->save();
            $request->session()->flash('success', "Post created");
            return redirect()->back();
        }
        else{
            abort(404);
        }
    }
    public function announcement($id,Request $request){
        $this->validate($request,[
            "id" => "required",
        ]);
        $group = Group::find($id);
        if($group===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if($group->owner_id == Auth::user()->id){
            $post = GroupPost::find($request->id);
            if($post->announcement===1){
                $post->announcement = 0;
            }
            else{
                $post->announcement = 1;
            }
            $post->save();
            $request->session()->flash('success', "Post updated");
            return redirect()->back();
        }
        else{
            abort(404);
        }
    }
    public function like($id,Request $request){
        $this->validate($request,[
            "id" => "required",
            "key" => "required",
        ]);
        $group = Group::find($id);
        if($group===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        if(GroupMember::where(["group_id"=>$group->id,"user_id"=>Auth::user()->id,"approved"=>1])->exists()){
            $post = GroupPost::find($request->id);
            $key = $request->key;
            if($key!=-1){
                $likes = json_decode($post->likes);
                unset($likes[(int)$key]);
                $post->likes = $likes;
                $request->session()->flash('success', "Post unliked");
            }
            else{
                $likes = json_decode($post->likes);
                $likes[] = [
                    "user_id"=>Auth::user()->id,
                ];
                $post->likes = $likes;
            }
            $post->save();
            return redirect()->back();
        }
        else{
            abort(404);
        }
    }
    public function delete($id,Request $request){
        $this->validate($request,[
            "id" => "required",
        ]);
        $group = Group::find($id);
        if($group===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        $post = GroupPost::find($request->id);
        if($group->owner_id == Auth::user()->id || Auth::user()->id === $post->user_id){
            $post->delete();
            $request->session()->flash('success', "Post Deleted");
            return redirect()->back();
        }
        else{
            abort(404);
        }
    }
    public function comment($id,Request $request){
        $this->validate($request,[
            "id" => "required",
            "comment" => "required",
        ]);
        $group = Group::find($id);
        if($group===NULL){
            abort(404,"The content you are trying to access does not exist");
        }
        $post = GroupPost::find($request->id);
        if(GroupMember::where(["group_id"=>$group->id,"user_id"=>Auth::user()->id,"approved"=>1])->exists()){
            $comments = json_decode($post->comments);
            $comments[] = [
                "user_id"=>Auth::user()->id,
                "comment"=>$request->comment,
                "created_at"=>date("Y-m-d H:i:s"),
            ];
            $post->comments = $comments;
            $post->save();
            $request->session()->flash('success', "Comment posted");
            return redirect()->back();
        }
        else{
            abort(404);
        }
    }
}
