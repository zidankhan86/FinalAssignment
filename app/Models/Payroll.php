<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function user(){
        return $this->belongsTo(User::class,"user_id","id");
    }
    public function salarystructure(){
        return $this->belongsTo(Salary_structure::class,"salary_structure_id","id");
    }
}
