<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Attendence;
use Illuminate\Http\Request;
// use Carbon\Carbon;

use Illuminate\Support\Facades\Validator;


 use Illuminate\Contracts\Auth\Factory;
 use Illuminate\Contracts\Auth\Guard;

class AttendenceController extends Controller
{
    public function attendence()
    {
      $attendences=Attendence::where('user_id',auth()->user()->id)->get();
      // dd( $attendences[0]->out_time);
      return view('backend.pages.attendence.attendencelist',compact('attendences'))->with('data', $attendences);
      
    }

  
    public function store(Request $request)
    {
      Attendence::create([
      'in_time'=>$request->in_time,
      'out_time'=>$request->out_time,
      'date'=>$request->date,
      'status'=>'absent',
      ]);
      return redirect()->route('attendence.list');

    }
    public function checkin(){

      
$status='Present';
      if (time() > strtotime("08:00:00")) {
        $status='Late';
      }

      
      $isAttendence = Attendence::whereDate("date",now())->where("user_id",auth()->user()->id)->first();
//dd($isAttendence);
     
      if($isAttendence){
        toastr()->error('already checked in');
        return redirect()->back();
      }


      Attendence::create([
        'in_time'=>now(),
        'date'=>date('Y-m-d'),
        'status'=>$status,
        'user_id'=>auth()->user()->id

      ]);
      toastr()->success("Checkedin done");
      return redirect()->back();
    }
    public function checkout(Request $request){
      $attendence = Attendence::whereDate("date",now())->where('user_id',auth()->user()->id)->first();


      if(isset($attendence->out_time)){
        toastr()->error('already checked out');
        return redirect()->back();
      }

      $in_time = now()->parse($attendence->in_time);
      $out_time = now()->parse($attendence->out_time);
    
      $attendence->update([
        'out_time'=>now(),
        'hour'=> $out_time->diffInHours($in_time)
      ]);
      return redirect()->back();
// attendence status
      
     
    }
    //attendence report 
    
    public function report()
    {
      return view('backend.pages.attendence.report');
    }
    public function reportSearch(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'from_date'    => 'required|date',
            'to_date'    => 'required|date|after_or_equal:from_date',
            
        ]);

        if($validator->fails())
        {

            toastr()->error('Invalid Date');
            return redirect()->back();
        }



       $form=$request->from_date;
       $to=$request->to_date;
       


//       $status=$request->status;

        $attendence=Attendence::whereBetween('created_at',[$form,$to] )->get();
        return view('backend.pages.attendence.report',compact('attendence'));

    }

    
   
    
}
