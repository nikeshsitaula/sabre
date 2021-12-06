<?php

namespace App\Models\TravelManagement;

use Illuminate\Database\Eloquent\Model;

class AccountManager extends Model
{
    protected $guarded = ['id'];

    public function travelagency(){
        return $this->belongsTo(TravelAgency::class,'ta_id','ta_id');
    }
}
