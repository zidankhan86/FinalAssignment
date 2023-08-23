<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function department()
    {
        $departments=Department::all();

        return view('backend.pages.department.departmentlist',compact('departments'));
    }
    public function departmentCreate()
    {
        return view('backend.pages.department.departmentCreate');
    }
    public function store(Request $request)
    {
     Department::create([
        'name'=>$request->name,

        ]);
        return redirect()->route('department.list');
    }
    public function view($id)
    {
      $departments = Department::find($id);
      return view('backend.pages.department.view',compact('departments'));
    }
    public function delete($id)
    {
        Department::find($id)->delete();

        return redirect()->back();
    }

}
