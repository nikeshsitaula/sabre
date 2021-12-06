<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $guarded = ['id'];

    public function experience()
    {
        return $this->hasMany(Experience::class,'emp_id','emp_id');
    }
}
