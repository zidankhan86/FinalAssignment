<?php

namespace App\Http\Controllers;

use App\Models\Attendence;
use App\Models\Payroll;
use App\Models\Salary_structure;
use App\Models\User;
use Attribute;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function payroll()

    {
        $payrolls=Payroll::with('user','salarystructure')->get();
        return view('backend.pages.payroll.list',compact('payrolls'));

    }
    public function create()
    {
        $users = User::all();
        $salary_structures = Salary_structure::all();
        return view('backend.pages.payroll.create',compact('users','salary_structures'));
    }


    public function store(Request $request)
    {
        //check already paid or not
        $checkPaid=Payroll::where('user_id',$request->user_id)->where('month',$request->month)->first();

        if($checkPaid)
        {
            toastr()->error('Already paid.');
            return redirect()->back();
        }


        $salary=Salary_structure::find($request->salary_structure_id);
        $totalBasic=$salary->basic;
        // dd($totalBasic);
        $totalmedicals=$salary->medicals;
        $totalmobile_bill=$salary->mobile_bill;
        



        $totalHour=Attendence::where('user_id',$request->user_id)->whereMonth('date',$request->month)->sum('hour');
        // dd($totalHour) ;
        $totalSalary=(((int)$totalBasic / 160) * (int)$totalHour) + $totalmedicals +  $totalmobile_bill ;
        $per_hour_rate=((int)$totalBasic /160);
//dd($per_hour_rate);
     Payroll::create([
        'user_id'=>$request->user_id,
        'salary_structure_id'=>$request->salary_structure_id,
        'month'=>$request->month,
        'totalSalary'=>$totalSalary,
        'totalworkingHour'=>'160',
        'totalHour'=>$totalHour,
        'per_hour_rate'=>$per_hour_rate,

        ]);
        return redirect()->route('payroll.list');
    }

}
