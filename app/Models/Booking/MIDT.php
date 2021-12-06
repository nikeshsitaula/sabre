<?php

namespace App\Models\Booking;

use App\Models\TravelManagement\TravelAgency;
use Illuminate\Database\Eloquent\Model;

class MIDT extends Model
{
    protected $guarded = ['id'];

    public function travelagency()
    {
        return $this->belongsTo(TravelAgency::class,'ta_id','ta_id');
    }
}
