<?php

namespace App\Http\Controllers;

use App\Models\Attendence;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\LeaveBalance;
use App\Models\Leavetype;
use App\Models\Product;
use App\Models\Salary_structure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
  public function home()
  {
    $employees = User::all()->count();
    $departments = Department::all()->count();
    $designations = Designation::all()->count();

    return view('dashboard', compact('employees', 'departments', 'designations'));
  }
  public function login()
  {
    return view('backend.pages.login');
  }

  public function dologin(Request $request)
  {
    // $credentials=$request->except('-token');

    $credentials = $request->only(['email', 'password']);
    if (Auth::attempt($credentials)) {
      return redirect()->route('home');
    }
    return redirect()->back()->with('message', 'invalid credentials');
  }
  public function logout()
  {
    auth()->logout();
    return redirect()->route('login');
  }
  public function profile()
  {
    $employees=User::all();
    return view('backend.pages.profile',compact('employees'));
  }
  public function land()
  {
    return view('backend.pages.landing');
  }

}
