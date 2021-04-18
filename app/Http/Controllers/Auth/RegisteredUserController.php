<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\GlobalMail;
use App\Models\Notification;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create($role)
    {
        $roles = ["Kid","Trainer","Organizer"];
        if(in_array($role,$roles)){
            return view('auth.register')->with([
                "role"=>$role
            ]);
        }
        else{
            abort(404);
        }
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'role' => "required|string",
        ]);

        Auth::login($user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]));

        event(new Registered($user));

        // Mail
        $sub = "Welcome to ".config("app.name");
        $message="<p>Dear ".$user->name.",</p><p>You have successfully created your account in ".config("app.name").". We are excited to have you on board.</p>";
        $data = array('sub'=>$sub,'message'=>$message);
        Mail::to($user->email)->send(new GlobalMail($data));

        $notification = new Notification;
        $notification->user_id = $user->id;
        $notification->message = "Welcome to ".config("app.name").".";
        $notification->save();

        return redirect(RouteServiceProvider::HOME);
    }
}
