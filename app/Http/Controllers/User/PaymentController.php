<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Course;
use App\Models\Webinar;
use App\Models\Mentoring;
use App\Models\Transaction;
use App\Models\Api as APIs;
use App\Models\EnrolledMentoring;
use App\Models\EnrolledWebinar;
use App\Models\EnrolledCourse;
use App\Models\GroupMember;
use Auth;
use PaytmWallet;
use Illuminate\Support\Facades\Mail;
use App\Mail\GlobalMail;
use App\Models\Notification;

class PaymentController extends Controller
{
    public function choose($type,$id,Request $request){
        if($type==="course"){
            $item = Course::find($id);
        }
        elseif($type==="webinar"){
            $item = Webinar::find($id);
        }
        elseif($type==="mentoring"){
            $item = Mentoring::find($id);
        }
        return view("users.payments.choose")->with([
            "type"=>$type,
            "id"=>$id,
            "item"=>$item,
            "date"=>$request->session()->get("date"),
            "time"=>$request->session()->get("time"),
        ]);
    }
    public function razorpay($type,$id,Request $request){
        if($type==="course"){
            $item = Course::find($id);
        }
        elseif($type==="webinar"){
            $item = Webinar::find($id);
        }
        elseif($type==="mentoring"){
            $item = Mentoring::find($id);
        }
        if($item===NULL){
            Session()->flash("error","The item does not exist");
            return redirect()->back();
        }
        return view("users.payments.razorpay")->with([
            "type"=>$type,
            "item"=>$item,
        ]);
    }
    public function razorpayPay($type,$id,Request $request){
        
        if($type==="course"){
            $item = Course::find($id);
        }
        elseif($type==="webinar"){
            $item = Webinar::find($id);
        }
        elseif($type==="mentoring"){
            $item = Mentoring::find($id);
        }
        if($item===NULL){
            Session()->flash("error","The item does not exist");
            return redirect()->back();
        }
        $input = $request->all();
        //get API Configuration 
        $apis = APIs::first();
        $api = new Api($apis->razorpay_key_id, $apis->razorpay_key_secret);
        //Fetch payment information by razorpay_payment_id
        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 

            } catch (\Exception $e) {
                return  $e->getMessage();
                \Session::put('error',$e->getMessage());
                return redirect()->back();
            }

            $transaction = new Transaction;
            $transaction->transaction_id = $input['razorpay_payment_id'];
            $transaction->user_id = Auth::user()->id;
            $transaction->item_type = $type;
            $transaction->item_id = $item->id;
            $transaction->amount = $payment['amount']/100;
            $transaction->status = "Paid";
            $transaction->payment_gateway = "Razorpay";
            $transaction->save();
            if($type==="course"){
                $item = Course::find($id);
                $enroll = new EnrolledCourse;
                $enroll->user_id = Auth::user()->id;
                $enroll->course_id = $item->id;
                $enroll->save();
    
                $groupm = new GroupMember;
                $groupm->group_id = $item->group->id;
                $groupm->user_id = Auth::user()->id;
                $groupm->approved = 1;
                $groupm->save();

                // Mail
                $user = Auth::user();
                $sub = "Welcome to ".$item->title;
                $message="<p>Dear ".$user->name.",</p><p>You have successfully enrolled to ".$item->title.".</p>";
                $data = array('sub'=>$sub,'message'=>$message);
                Mail::to($user->email)->send(new GlobalMail($data));
        
                $notification = new Notification;
                $notification->user_id = $user->id;
                $notification->message = "You have successfully enrolled to ".$item->title;
                $notification->save();
                $request->session()->flash('success', "You have successfully enrolled to the course");
                return redirect()->route('courses.view', [$item->id,md5($item->title)]);
            }
            elseif($type==="webinar"){
                $item = Webinar::find($id);
                $enroll = new EnrolledWebinar;
                $enroll->user_id = Auth::user()->id;
                $enroll->webinar_id = $item->id;
                $enroll->save();

                // Mail
                $user = Auth::user();
                $sub = "Welcome to ".$item->title;
                $message="<p>Dear ".$user->name.",</p><p>You have successfully subscribed to ".$item->title.".</p>";
                $data = array('sub'=>$sub,'message'=>$message);
                Mail::to($user->email)->send(new GlobalMail($data));
        
                $notification = new Notification;
                $notification->user_id = $user->id;
                $notification->message = "You have successfully subscribed to ".$item->title;
                $notification->save();
                $request->session()->flash('success', "You have successfully subscribed to the webinar");
                return redirect()->route('webinars.view', [$item->id,md5($item->title)]);
            }
            elseif($type==="mentoring"){
                $item = Mentoring::find($id);
                $enroll = new EnrolledMentoring;
                $enroll->user_id = Auth::user()->id;
                $enroll->mentoring_id = $item->id;
                $enroll->date = $request->date;
                $enroll->time = $request->time;
                $enroll->save();

                // Mail
                $user = Auth::user();
                $sub = "Welcome to ".$item->title;
                $message="<p>Dear ".$user->name.",</p><p>You have successfully subscribed to ".$item->title.".</p>";
                $data = array('sub'=>$sub,'message'=>$message);
                Mail::to($user->email)->send(new GlobalMail($data));
        
                $notification = new Notification;
                $notification->user_id = $user->id;
                $notification->message = "You have successfully subscribed to ".$item->title;
                $notification->save();
                $request->session()->flash('success', "You have successfully subscribed to the mentoring program");
                return redirect()->route('mentorings.view', [$item->id,md5($item->title)]);
            }
        }
    }
    public function paytm($type,$id){
        if($type==="course"){
            $item = Course::find($id);
        }
        elseif($type==="webinar"){
            $item = Webinar::find($id);
        }
        elseif($type==="mentoring"){
            $item = Mentoring::find($id);
        }
        if($item===NULL){
            Session()->flash("error","The item does not exist");
            return redirect()->back();
        }
        $payment = PaytmWallet::with('receive');
        $payment->prepare([
          'order' => $item->id,
          'user' => Auth::user()->id,
          'mobile_number' => Auth::user()->mobile,
          'email' => Auth::user()->email,
          'amount' => $item->price,
          'callback_url' => route("user.payment.paytm.pay",[$type,$item->id])
        ]);
        return $payment->receive();
    }
    public function paytmPay($type,$id,Request $request){
        
        if($type==="course"){
            $item = Course::find($id);
        }
        elseif($type==="webinar"){
            $item = Webinar::find($id);
        }
        elseif($type==="mentoring"){
            $item = Mentoring::find($id);
        }
        if($item===NULL){
            Session()->flash("error","The item does not exist");
            return redirect()->back();
        }
        $status = PaytmWallet::with('receive');
        
        $response = $status->response(); // To get raw response as array
        //Check out response parameters sent by paytm here -> http://paywithpaytm.com/developer/paytm_api_doc?target=interpreting-response-sent-by-paytm
        
        if($status->isSuccessful()){

            $transaction = new Transaction;
            $transaction->transaction_id = $status->getTransactionId();
            $transaction->user_id = Auth::user()->id;
            $transaction->item_type = $type;
            $transaction->item_id = $item->id;
            $transaction->amount = $item->price;
            $transaction->payment_gateway = "Paytm";
            $transaction->save();
            if($type==="course"){
                $item = Course::find($id);
                $enroll = new EnrolledCourse;
                $enroll->user_id = Auth::user()->id;
                $enroll->course_id = $item->id;
                $enroll->save();
    
                $groupm = new GroupMember;
                $groupm->group_id = $item->group->id;
                $groupm->user_id = Auth::user()->id;
                $groupm->approved = 1;
                $groupm->save();
                $request->session()->flash('success', "You have successfully enrolled to the course");
                return redirect()->route('courses.view', [$item->id,md5($item->title)]);
            }
            elseif($type==="webinar"){
                $item = Webinar::find($id);
                $enroll = new EnrolledWebinar;
                $enroll->user_id = Auth::user()->id;
                $enroll->webinar_id = $item->id;
                $enroll->save();
                $request->session()->flash('success', "You have successfully subscribed to the webinar");
                return redirect()->route('webinars.view', [$item->id,md5($item->title)]);
            }
            elseif($type==="mentoring"){
                $item = Mentoring::find($id);
                $enroll = new EnrolledMentoring;
                $enroll->user_id = Auth::user()->id;
                $enroll->mentoring_id = $item->id;
                $enroll->save();
                $request->session()->flash('success', "You have successfully subscribed to the mentoring program");
                return redirect()->route('mentorings.view', [$item->id,md5($item->title)]);
            }
        }else if($status->isFailed()){
          return "Paytment Failed";
        }else if($status->isOpen()){
            return "Payment Processing";
        }
    }
}
