<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Program;
use App\Models\Event;
use App\Models\Transaction;
use App\Models\Api as APIs;
use App\Models\EnrolledProgram;
use App\Models\EnrolledEvent;
use Auth;
use PaytmWallet;
use Illuminate\Support\Facades\Mail;
use App\Mail\GlobalMail;
use App\Models\Notification;

class PaymentController extends Controller
{
    public function choose($type,$id,Request $request){
        if($type==="program"){
            $date = $request->session()->get("day");
            $time = $request->session()->get("time");
            $item = Program::find($id);
            $typee = $request->session()->get("typee");
        }
        if($type==="event"){
            $date = "";
            $time = "";
            $item = Event::find($id);
            $typee="";
        }
        return view("users.payments.choose")->with([
            "type"=>$type,
            "id"=>$id,
            "item"=>$item,
            "date"=>$date,
            "time"=>$time,
            "typee"=>$typee,
        ]);
    }
    public function razorpay($type,$id,Request $request){
        if($type==="program"){
            $item = Program::find($id);
        }
        if($type==="event"){
            $item = Event::find($id);
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
        
        if($type==="program"){
            $item = Program::find($id);
            $owner = $item->trainer;
        }
        if($type==="event"){
            $item = Event::find($id);
            $owner = $item->organiser;
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

            $owner->wallet = $payment['amount']/100;
            $owner->save();

            if($type==="program"){
                $item = Program::find($id);
                $enroll = new EnrolledProgram;
                $enroll->user_id = Auth::user()->id;
                $enroll->program_id = $item->id;
                $enroll->day = $request->date;
                $enroll->time = $request->time;
                $enroll->type = $request->typee;
                $enroll->save();
                

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
                $request->session()->flash('success', "You have successfully enrolled to the program");
                return redirect()->route('programs.view', [$item->id,md5($item->title)]);
            }
            if($type==="event"){
                $item = Event::find($id);
                $enroll = new EnrolledEvent;
                $enroll->user_id = Auth::user()->id;
                $enroll->event_id = $item->id;
                $enroll->save();

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
                $request->session()->flash('success', "You have successfully enrolled to the event");
                return redirect()->route('events.view', [$item->id,md5($item->title)]);
            }
        }
    }
    // public function paytm($type,$id){
    //     if($type==="course"){
    //         $item = Course::find($id);
    //     }
    //     elseif($type==="webinar"){
    //         $item = Webinar::find($id);
    //     }
    //     elseif($type==="mentoring"){
    //         $item = Mentoring::find($id);
    //     }
    //     if($item===NULL){
    //         Session()->flash("error","The item does not exist");
    //         return redirect()->back();
    //     }
    //     $payment = PaytmWallet::with('receive');
    //     $payment->prepare([
    //       'order' => $item->id,
    //       'user' => Auth::user()->id,
    //       'mobile_number' => Auth::user()->mobile,
    //       'email' => Auth::user()->email,
    //       'amount' => $item->price,
    //       'callback_url' => route("user.payment.paytm.pay",[$type,$item->id])
    //     ]);
    //     return $payment->receive();
    // }
    // public function paytmPay($type,$id,Request $request){
        
    //     if($type==="course"){
    //         $item = Course::find($id);
    //     }
    //     elseif($type==="webinar"){
    //         $item = Webinar::find($id);
    //     }
    //     elseif($type==="mentoring"){
    //         $item = Mentoring::find($id);
    //     }
    //     if($item===NULL){
    //         Session()->flash("error","The item does not exist");
    //         return redirect()->back();
    //     }
    //     $status = PaytmWallet::with('receive');
        
    //     $response = $status->response(); // To get raw response as array
    //     //Check out response parameters sent by paytm here -> http://paywithpaytm.com/developer/paytm_api_doc?target=interpreting-response-sent-by-paytm
        
    //     if($status->isSuccessful()){

    //         $transaction = new Transaction;
    //         $transaction->transaction_id = $status->getTransactionId();
    //         $transaction->user_id = Auth::user()->id;
    //         $transaction->item_type = $type;
    //         $transaction->item_id = $item->id;
    //         $transaction->amount = $item->price;
    //         $transaction->payment_gateway = "Paytm";
    //         $transaction->save();
    //         if($type==="course"){
    //             $item = Course::find($id);
    //             $enroll = new EnrolledCourse;
    //             $enroll->user_id = Auth::user()->id;
    //             $enroll->course_id = $item->id;
    //             $enroll->save();
    
    //             $groupm = new GroupMember;
    //             $groupm->group_id = $item->group->id;
    //             $groupm->user_id = Auth::user()->id;
    //             $groupm->approved = 1;
    //             $groupm->save();
    //             $request->session()->flash('success', "You have successfully enrolled to the course");
    //             return redirect()->route('courses.view', [$item->id,md5($item->title)]);
    //         }
    //         elseif($type==="webinar"){
    //             $item = Webinar::find($id);
    //             $enroll = new EnrolledWebinar;
    //             $enroll->user_id = Auth::user()->id;
    //             $enroll->webinar_id = $item->id;
    //             $enroll->save();
    //             $request->session()->flash('success', "You have successfully subscribed to the webinar");
    //             return redirect()->route('webinars.view', [$item->id,md5($item->title)]);
    //         }
    //         elseif($type==="mentoring"){
    //             $item = Mentoring::find($id);
    //             $enroll = new EnrolledMentoring;
    //             $enroll->user_id = Auth::user()->id;
    //             $enroll->mentoring_id = $item->id;
    //             $enroll->save();
    //             $request->session()->flash('success', "You have successfully subscribed to the mentoring program");
    //             return redirect()->route('mentorings.view', [$item->id,md5($item->title)]);
    //         }
    //     }else if($status->isFailed()){
    //       return "Paytment Failed";
    //     }else if($status->isOpen()){
    //         return "Payment Processing";
    //     }
    // }
}
