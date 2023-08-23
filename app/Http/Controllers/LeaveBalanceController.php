<?php

namespace App\Http\Controllers;

use App\Models\LeaveBalance;
use App\Models\Leavetype;
use App\Models\User;
use Illuminate\Http\Request;

class LeaveBalanceController extends Controller
{
    public function leaveBalance()
    {
        $leavebalances=LeaveBalance::with('user','leavetype')->get();
        if(auth()->user()->role == "employee"){
        $leavebalances=LeaveBalance::where("user_id",auth()->user()->id)->with("user","leavetype")->get();
        }
        return view('backend.pages.leaveBalance.list',compact('leavebalances'));
    }
    public function create()
    {
        $users=User::with('leavetype')->where('user_id',auth()->user()->id)->get();
        $leavetypes=Leavetype::all();

        return view('backend.pages.leaveBalance.create',compact('users','leavetypes'));
    }
    public function store(Request $request)
    {
        LeaveBalance::create([
            'user_id'=>$request->user_id,
            'balance'=>$request->balance,
        ]);
        return redirect()->route('leaveBalance.list');

    }
}
