<?php

namespace App\Http\Controllers\Mentee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Auth;

class TransactionController extends Controller
{
    public function index(){
        $transactions = Transaction::where("user_id",Auth::user()->id)->latest()->paginate(15);
        return view("mentee.transactions")->with([
            "transactions" => $transactions
        ]);
    }
}
