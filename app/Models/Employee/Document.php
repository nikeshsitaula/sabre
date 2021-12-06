<?php

namespace App\Models\Employee;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $guarded = ['id'];

    public function images()
    {
        return $this->hasMany(DocumentImage::class,'document_id', 'id');
    }
}
