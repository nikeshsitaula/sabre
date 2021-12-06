<?php

namespace App\Models\TravelManagement;

use Illuminate\Database\Eloquent\Model;

class TravelAgency extends Model
{
    protected $guarded = ['id'];

    public function pcc()
    {
        return $this->hasMany(PCC::class,'ta_id','ta_id');
    }
}
