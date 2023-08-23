<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    public function leaveType()
    {  $leavetypes=LeaveType::all();
        return view('backend.pages.leaveType.list',compact('leavetypes'));
    }
    public function create()
    {
        return view('backend.pages.leaveType.create');
    }
    public function store(Request $request)
    {
      LeaveType::create([
         
        'name'=>$request->name,
        'days'=>$request->days,
        'description'=>$request->description,


      ]); 
      return redirect()->route('leaveType.list');
    }
    public function view($id)
    {
      $leavetypes =LeaveType::find($id);
      return view('backend.pages.leaveType.view',compact('leavetypes'));
    }
    public function delete($id)
    {
        LeaveType::find($id)->delete();

        return redirect()->back();
    }
}
