<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $guarded = ['id'];

    public function employee(){
        return $this->belongsTo(Employee::class,'emp_id','emp_id');
    }

}
