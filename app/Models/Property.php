<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $guarded=[];
    public function landlord(){
        return $this->belongsTo(User::class,'landlord_id');
    }
    public function units(){
        return $this->hasMany(Unit::class);
    }
}
