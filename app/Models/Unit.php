<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $guarded=[];
    public function property(){
        return $this->belongsTo(Property::class);
    }

    public function tenancies(){
        return $this->hasMany(Tenancy::class);
    }

    public function activeTenancy(){
        return $this->hasOne(Tenancy::class)->whereNull('end_date');
    }
}
