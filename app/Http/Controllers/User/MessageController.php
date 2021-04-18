<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Auth;

class MessageController extends Controller
{
    public function index(){
        $message = Message::where("sender_id",Auth::user()->id)->orWhere("receiver_id",Auth::user()->id)->latest()->first();
        if($message==NULL){
            return view("users.messages.messages")->with([
                "messages" => $message,
                "receiver" => NULL
            ]);
        }
        else{
            if($message->sender_id==Auth::user()->id){
                $rid = $message->receiver_id;
            }
            else{
                $rid = $message->sender_id;
            }
            return redirect()->route('user.messages', ["id"=>$rid]);
        }
    }
    public function messages($id){
        if(User::find($id) === NULL){
            abort(404);
        }
        else{
            $sid = Auth::user()->id;
            $rid = $id;
            $receiver = User::find($id);
            $messages = Message::where(["sender_id"=>$sid,"receiver_id"=>$rid])
                                ->orWhere(function($query) use ($rid,$sid) {
                                    $query->where('sender_id', $rid)
                                        ->where('receiver_id', $sid);
                                })->oldest()->get();
            $chats = Message::where("sender_id",Auth::user()->id)->orWhere("receiver_id",Auth::user()->id)->latest()->get();
            return view("users.messages.messages")->with([
                "messages"=>$messages,
                "receiver"=>$receiver,
                "chats"=>$chats,
            ]);
        }
    }
    public function sendMessage(Request $request){
        $this->validate($request,[
            'message' => 'required',
            'receiver' => 'required',
        ]);
        $messagee = $request->message;
        $messagee = str_replace("<div><br></div>","",$messagee);
        $message = new Message;
        $message->sender_id = Auth::user()->id;
        $message->receiver_id = $request->receiver;
        $message->message = $messagee;
        $message->save();
        return 1;
    }
    public function sendFile(Request $request){
        $this->validate($request,[
            'messageFile' => 'required',
            'receiver' => 'required',
        ]);
        $path = "assets/users/message/files/";
        $name = $_FILES['messageFile']['name'];
        $tmp = $_FILES['messageFile']['tmp_name'];
        $fname = time().$name;
        if(move_uploaded_file($tmp,$path.$fname)){
            $message = new Message;
            $message->sender_id = Auth::user()->id;
            $message->receiver_id = $request->receiver;
            $msg = "<a href=\"".asset($path.$fname)."\" class=\"file-msg\" target=\"_blank\">{$name}</a>";
            $message->message = $msg;
            $message->save();
            return 1;
        }
        else{
            return 0;
        }
    }
    public function sendImage(Request $request){
        $this->validate($request,[
            'messageImage' => 'required|image',
            'receiver' => 'required',
        ]);
        $path = "assets/users/message/images/";
        $name = $_FILES['messageImage']['name'];
        $tmp = $_FILES['messageImage']['tmp_name'];
        $fname = time().$name;
        if(move_uploaded_file($tmp,$path.$fname)){
            $message = new Message;
            $message->sender_id = Auth::user()->id;
            $message->receiver_id = $request->receiver;
            $msg = "<a href=\"#img\" class=\"img-msg\" onclick=\"view_img(this)\"><img src=\"".asset($path.$fname)."\" class=\"img-msg-img\"></a>";
            $message->message = $msg;
            $message->save();
            return 1;
        }
        else{
            return 0;
        }
    }
    public function message($id){
        if(User::find($id) === NULL){
            abort(404);
        }
        else{
            $sid = Auth::user()->id;
            $rid = $id;
            $message = Message::where(["sender_id"=>$sid,"receiver_id"=>$rid])
                                ->orWhere(function($query) use ($rid,$sid) {
                                    $query->where('sender_id', $rid)
                                        ->where('receiver_id', $sid);
                                })->first();
            if($message==NULL){
                return view("users.messages.message")->with([
                    "receiver"=>$id
                ]);
            }
            else{
                return redirect()->route('user.messages', ["id"=>$id]);
            }
        }
    }
    public function sendM(Request $request,$receiver){
        $this->validate($request,[
            "message" => "required"
        ]);
        $messagee = $request->message;
        $messagee = str_replace("<div><br></div>","",$messagee);
        $message = new Message;
        $message->sender_id = Auth::user()->id;
        $message->receiver_id = $receiver;
        $message->message = $messagee;
        $message->save();
        return redirect()->route('user.chats');
    }
    public function messagesA(Request $request){
        $this->validate($request,[
            "receiver" =>"required"
        ]);
        $id = $request->receiver;
        if(User::find($id) === NULL){
            abort(404);
        }
        else{
            $sid = Auth::user()->id;
            $rid = $id;
            $receiver = User::find($id);
            $messages = Message::where(["sender_id"=>$sid,"receiver_id"=>$rid])
                                ->orWhere(function($query) use ($rid,$sid) {
                                    $query->where('sender_id', $rid)
                                        ->where('receiver_id', $sid);
                                })->oldest()->get();
            return response()->json(array('messages'=>$messages), 200);
        }
    }
}
