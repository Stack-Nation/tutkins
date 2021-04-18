<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Forum;
use App\Models\ForumPost;
use App\Models\EnrolledCourse;
use Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class MainController extends Controller
{
    public function index($id,$name){
        $forum = Forum::find($id);
        if($forum===NULL){
            abort(404);
        }
        if($name === md5($forum->name)){
            if(EnrolledCourse::where(["course_id"=>$forum->course_id,"user_id"=>Auth::user()->id])->exists()){
                $posts = ForumPost::where("forum_id",$forum->id)->latest()->paginate(15);
                $course = $forum->course;
                $course->content = json_decode($course->content);
                return view("posts.index")->with([
                    "forum"=>$forum,
                    "posts"=>$posts,
                    "course"=>$course,
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
    public function view($id,$title){
        $post = ForumPost::find($id);
        if($post===NULL){
            abort(404);
        }
        if($title === md5($post->title)){
            if(EnrolledCourse::where(["course_id"=>$post->forum->course_id,"user_id"=>Auth::user()->id])->exists()){
                $course = $post->forum->course;
                $course->content = json_decode($course->content);
                $post->comments = \json_decode($post->comments);
                if($post->comments):
                    $post->comments = array_reverse($post->comments);
                endif;
                $comments = $this->paginate($post->comments,$post);
                return view("posts.view")->with([
                    "post"=>$post,
                    "course"=>$course,
                    "comments"=>$comments,
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
    public function create($id,$name){
        $forum = Forum::find($id);
        if($forum===NULL){
            abort(404);
        }
        if($name === md5($forum->name)){
            if(EnrolledCourse::where(["course_id"=>$forum->course_id,"user_id"=>Auth::user()->id])->exists()){
                $course = $forum->course;
                $course->content = json_decode($course->content);
                return view("posts.create")->with([
                    "forum"=>$forum,
                    "course"=>$course,
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
    public function store($id,$name,Request $request){
        $forum = Forum::find($id);
        if($forum===NULL){
            abort(404);
        }
        if($name === md5($forum->name)){
            if(EnrolledCourse::where(["course_id"=>$forum->course_id,"user_id"=>Auth::user()->id])->exists()){
                $this->validate($request,[
                    "title"=>"required",
                    "body"=>"required",
                ]);
                $post = new ForumPost;
                $post->title = $request->title;
                $post->body = $request->body;
                $post->user_id = Auth::user()->id;
                $post->forum_id = $forum->id;
                $post->save();
                $request->session()->flash('success', "Post successfully created");
                return redirect()->back();
            }
            else{
                abort(404);
            }
        }
        else{
            abort(404);
        }
    }
    public function delete(Request $request){
        $this->validate($request,[
            "id"=>"required"
        ]);
        $post = ForumPost::find($request->id);
        $post->delete();
        $request->session()->flash('success', "Post successfully deleted");
        return redirect()->route('posts.index',[$post->forum_id,md5($post->forum->name)]);
    }
    public function comment($id,Request $request){
        $post = ForumPost::find($id);
        if($post===NULL){
            abort(404);
        }
        if(EnrolledCourse::where(["course_id"=>$post->forum->course_id,"user_id"=>Auth::user()->id])->exists()){
            $this->validate($request,[
                "comment" => "required",
            ]);
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
   
    public function paginate($items,$post, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, ['path' => Paginator::resolveCurrentPath()]);
    }
}