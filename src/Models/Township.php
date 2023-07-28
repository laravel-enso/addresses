<?php

namespace LaravelEnso\Addresses\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\DynamicMethods\Traits\Abilities;
use LaravelEnso\Rememberable\Traits\Rememberable;

class Township extends Model
{
    use Abilities, HasFactory, Rememberable;

    protected $guarded = [];

    protected $rememberableKeys = ['id', 'name'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function localities()
    {
        return $this->hasMany(Locality::class);
    }
}
