<?php

namespace LaravelEnso\Addresses\Models;

use Illuminate\Database\Eloquent\Model;

class Township extends Model
{
    protected $guarded = ['id'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function localities()
    {
        return $this->hasMany(Locality::class);
    }
}