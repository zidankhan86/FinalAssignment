<?php
namespace App\Http\Controllers;


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Models\Designation;
use App\Models\Salary_structure;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/',[HomeController::class,'land'])->name('land');


Route::get('/login',[HomeController::class,'login'])->name('login');
Route::post('/do-login',[HomeController::class,'doLogin'])->name('do.login');

//for employee
Route::group(['middleware'=>'auth'],function(){
    Route::get('/home',[HomeController::class,'home'])->name('home');
    Route::get('/home/logout',[HomeController::class,'logout'])->name('logout');
Route::get('/home/profile',[HomeController::class,'profile'])->name('home.profile');
    //leave balance
Route::get('/leaveBalance',[LeaveBalanceController::class,'leaveBalance'])->name('leaveBalance.list');
Route::get('/leaveBalance/create',[LeaveBalanceController::class,'create'])->name('leavebalance.create');
Route::post('/leaveBalance/store',[LeaveBalanceController::class,'store'])->name('leavebalance.store');
Route::get('/attendence',[AttendenceController::class,'attendence'])->name('attendence.list');
//attendence
Route::post('/attendence/store',[AttendenceController::class,'store'])->name('attendence.store');
Route::get('/attendence/checkin',[AttendenceController::class,'checkin'])->name('attendence.checkin');
Route::get('/attendence/checkout',[AttendenceController::class,'checkout'])->name('attendence.checkout');

//attendence report
Route::get('/attendence/dailyreport',[AttendenceController::class,'dailyreport'])->name('attendence.dailyreport');

Route::get('/attendence/report',[AttendenceController::class,'report'])->name('attendence.report');
Route::get('/attendence/report/search',[AttendenceController::class,'reportSearch'])->name('attendence.report.search');
//leave application
Route::get('/leave',[LeaveController::class,'leave'])->name('leave.list');
Route::get('leave/create',[LeaveController::class,'create'])->name('leave.create');
Route::post('leave/store',[LeaveController::class,'store'])->name('leave.store');
//checkAdmin
Route::group(['middleware'=>'checkAdmin'],function(){


Route::get('/employee',[UserController::class, 'employee'])->name('employee.list');
Route:: get('/employee/create',[UserController::class,'employeeCreate']);
Route::post('/employee/store',[UserController::class,'store'])->name('employee.store');
Route::get('/employee/view{id}',[UserController::class,'view'])->name('employee.view');
Route::get('/employee/delete{id}',[UserController::class,'delete'])->name('employee.delete');
Route::get('/employee/edit{id}',[UserController::class,'edit'])->name('employee.edit');
Route::put('/employee/update{id}',[UserController::class,'update'])->name('employee.update');



//for designation
Route::get('/designation',[DesignationController::class,'designation'])->name('designation.list');
Route::get ('/designation/create',[DesignationController::class,'designationCreate']);
Route::post('/designation/store',[DesignationController::class,'store'])->name('designation.store');
Route::get('/designation/view{id}',[DesignationController::class,'view'])->name('designation.view');
Route::get('/designation/delete{id}',[DesignationController::class,'delete'])->name('designation.delete');
//for department
Route::get('/department',[DepartmentController::class,'department'])->name('department.list');
Route::get('/department/create',[DepartmentController::class,'departmentCreate'])->name('department.Create');
Route::post('/department/store',[DepartmentController::class,'store'])->name('department.store');
Route::get('/department/view{id}',[DepartmentController::class,'view'])->name('department.view');
Route::get('/department/delete{id}',[DepartmentController::class,'delete'])->name('department.delete');

//for payroll
Route::get('/payroll',[PayrollController::class,'payroll'])->name('payroll.list');
Route::get('/payroll/create',[PayrollController::class,'create'])->name('payroll.create');
Route::post('/payroll/store',[PayrollController::class,'store'])->name('payroll.store');

//for leaveBalance



//for leavetype
Route::get('/leaveType',[LeaveTypeController::class,'leaveType'])->name('leaveType.list');
Route::get('/leaveType/create',[LeaveTypeController::class,'create'])->name('leavetype.create');
Route::post('/leaveType/store',[LeaveTypeController::class,'store'])->name('leavetype.store');
Route::get('/leavetype/view{id}',[DepartmentController::class,'view'])->name('leavetype.view');
Route::get('/leavetype/delete{id}',[DepartmentController::class,'delete'])->name('leavetype.delete');


//for leave application

Route::get('leave/approve{id}',[LeaveController::class,'approve'])->name('leave.approve');
Route::get('leave/reject{id}',[LeaveController::class,'reject'])->name('leave.reject');


    });
});

