<?php

namespace App\Http\Controllers;

use toastr;
use DateTime;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Leave;
use App\Models\LeaveBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeaveController extends Controller
{
    public function leave()
    {
        $leaves=Leave::with("user","leavetype")->get();
        if(auth()->user()->role == "employee"){
        $leaves=Leave::where("user_id",auth()->user()->id)->with("user","leavetype")->get();
        }
       return view('backend.pages.leave.list',compact('leaves'));
    }
    public function create()
    {
        $users=User::all();
        $leavetypes=LeaveBalance::with('leavetype')->where('user_id',auth()->user()->id)->get();
        // dd($leavetypes);
        return view('backend.pages.leave.create',compact('users','leavetypes'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'fromdate'=>'required|after:now',
            'todate'=>'required|date|after_or_equal:fromdate',
        ]);

        if($validator->fails())
        {
            toastr()->error('Date is invalid!');
            return redirect()->back();
        }

        $fdate=$request->fromdate;
        $tdate=$request->todate;
         
       
    
        $datetime1 = new DateTime($fdate);
        $datetime2 = new DateTime($tdate);
    
        $days = $datetime2->diff($datetime1)->format('%a')+1;
        
        //check employee has balance
        $leaveBalance=LeaveBalance::where('user_id',$request->user_id)
        ->where('leavetype_id',$request->leavetype_id)->first();

        //check leave exist
        $leaveExistFromDate=Leave::whereDate('fromdate','>=',$datetime1)->whereDate('fromdate','<=',$datetime2)->where('user_id',auth()->user()->id)->first();
        $leaveExistToDate=Leave::whereDate('todate','>=',$datetime1)->whereDate('todate','<=',$datetime2)->where('user_id',auth()->user()->id)->first();



       
if($leaveExistFromDate OR $leaveExistToDate)
{
    toastr()->error('You have already leave on those date', 'Error');

    return redirect()->back();
}

        if($leaveBalance->balance >= $days)
        {
           
            Leave::create([
                'user_id'=>$request->user_id,
                'title'=>$request->title,
                'fromdate'=>$request->fromdate,
                'todate'=>$request->todate,
                'leavetype_id'=>$request->leavetype_id,
                'status'=>'pending',
            ]);

    
            // remove from leave balance
            $leaveBalance->decrement('balance',$days);
            //message : leave applied success
            toastr()->success('Leave Applied Successfully!', 'Congrats');

            return redirect()->route('leave.list');
        }
    //  message: insufficiant balance
    toastr()->error('insufficient balance');

      
        return redirect()->route('leave.list');
    }
    public function approve($id)
    {
      $leave = Leave::findOrFail($id);
      $leave->status='approved';
      $leave->save();
      toastr()->success('leave has been approved');
    return redirect()->route('leave.list');
    }
    public function reject($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->status='declined';
        $leave->save();

        if(isset($leave->status->declined))
        {
        $datetime1 = new DateTime($leave->formdate);
        $datetime2 = new DateTime($leave->todate);
    
        $days =( $datetime2->diff($datetime1))->format('%a')+1;
        
        //leave restore into balance
        $balance=LeaveBalance::where('leavetype_id',$leave->leavetype_id)
        ->where('user_id',$leave->user_id)->first();
        
        $balance->increment('balance',$days);
        toastr()->error('leave has been rejected');
        }
        return redirect()->route('leave.list');
        
    }
}
