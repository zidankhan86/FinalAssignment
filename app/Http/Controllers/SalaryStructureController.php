<?php

namespace App\Http\Controllers;

use App\Models\Salary_structure;
use App\Models\SalaryStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalaryStructureController extends Controller
{
    public function salaryStructure()

    {
        $salary_structures=Salary_structure::all();

       
        return view('backend.pages.salaryStructure.list',compact('salary_structures'));
    }

    public function create()
    {
        return view('backend.pages.salaryStructure.createform');
    }
    public function store(Request $request)
   { 
    //dd($request->all());
    $validate=Validator::make($request->all(),[
        'salaryclass'=>'required',
        'basic'=>'required',
        'medicals'=>'required',
        'mobile_bill'=>'required',
        
    ]);
    if($validate->fails())
    {
        toastr()->error($validate->getMessageBag());
        return redirect()->route('salaryStructure.create');
    }

    
    Salary_structure::create([
    'salaryclass'=>$request->salaryclass,
    'basic'=>$request->basic,
    'medicals'=>$request->medicals,
    'mobile_bill'=>$request->mobile_bill,



    ]);

    return redirect()->route('salaryStructure.list');
   }
   public function view($id)
    {
      $salary_structures =Salary_structure::find($id);
      return view('backend.pages.salaryStructure.view',compact('salary_structures'));
    }
    public function delete($id)
    {
        Salary_structure::find($id)->delete();

        return redirect()->back();
    }
        
}
