<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\LeaveBalance;
use App\Models\Leavetype;
use App\Models\Salary_structure;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UserController extends Controller
{
    public function employee()
    {
        if(\request()->from_date){

            $validate=Validator::make(\request()->all(),[
                'to_date'=>'after:from_date'
             ]);
             if($validate->fails())
             {
                 toastr()->error('To date should greater than from date.');
                 return redirect()->route('employee.list');
             }
        $employees = User::with("designation")->whereBetween('created_at',[\request()->from_date,\request()->to_date])->paginate(4);
        }
        else{
            $employees=User::with('designation')->paginate(4);
        }
        return view('backend.pages.employee.employeelist', compact('employees'));
    }

    public function  employeeCreate()
    {
        $designations = Designation::all();
        $departments = Department::all();
        $salary_structures = Salary_structure::all();
        return view('backend.pages.employee.employeeCreate', compact('designations', 'departments', 'salary_structures'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $validate=Validator::make($request->all(),[
            'name' =>'required',
           'email' =>'required',
           'password' =>'required',
           'number' =>'required',
        ]);
        if($validate->fails())
        {
            toastr()->error($validate->getMessageBag());
//            notify()->error("Somethings went wrong.");
            return redirect()->back();
        }

        $fileName='';
        if($request->hasFile('employee_image'))
        {
        $fileName=date('Ymdhis').'.'.$request->file('employee_image')->getClientOriginalExtension();

        $request->file('employee_image')->storeAs('/uploads',$fileName);


       }
       try{
        DB::beginTransaction();
        $user= User::create([
             'name' => $request->name,
             'number' => $request->number,
             'email' => $request->email,
             'role'=>$request->role,
             'password' =>bcrypt($request->password),
             'designation_id' => $request->designation_id,
             'department_id' => $request->department_id,
             'salary_structure_id' => $request->salary_structure_id,
             'image'=>$fileName
 
         ]); 
        
 
         $leaveType=Leavetype::all();
         
         foreach($leaveType as $lt)
         {
             LeaveBalance::create([
                 'user_id'=>$user->id,
                 'leavetype_id'=>$lt->id,
                 'balance'=>$lt->days,
             ]);
         }
         toastr()->success('Data has been saved successfully!', 'Congrats');
         DB::commit();

       }catch(Throwable $e){
            DB::rollBack();
            toastr()->error($e->getMessage(), 'Error');
            return redirect()->back();
       }
      //dd($user->all());

        return redirect()->route('employee.list');
    }

    public function view($id)
    {
        $employees = User::find($id);
        $designations = Designation::find($id);


        return view('backend.pages.employee.view', compact('employees','designations'));
    }
    public function delete($id)
    {
        User::find($id)->delete();

        return redirect()->back();
    }
    public function edit($id)
    {
       $employees = User::find($id);
       $designations = Designation::all();
       $departments = Department::all();
       $salary_structures = Salary_structure::all();
       return view('backend.pages.employee.edit',compact('employees','designations','departments','salary_structures'));
    }
    public function update(Request $request,$id)
    {
        
        $fileName='';
        if($request->hasFile('employee_image'))
        {
        $fileName=date('Ymdhis').'.'.$request->file('employee_image')->getClientOriginalExtension();

        $request->file('employee_image')->storeAs('/uploads',$fileName);

        $employees = User::find($id);
        $employees->update([
            'name' => $request->name,
             'number' => $request->number,
             'email' => $request->email,
             'role'=>$request->role,
             'password' =>bcrypt($request->password),
             'designation_id' => $request->designation_id,
             'department_id' => $request->department_id,
             'salary_structure_id' => $request->salary_structure_id,
             'image'=>$fileName

        ]);

       

    }
    return to_route('employee.list');
}
}