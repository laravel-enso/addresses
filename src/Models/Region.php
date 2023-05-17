<?php

namespace LaravelEnso\Addresses\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Countries\Models\Country;
use LaravelEnso\Helpers\Contracts\Activatable;
use LaravelEnso\Helpers\Traits\ActiveState;
use LaravelEnso\Rememberable\Traits\Rememberable;

class Region extends Model implements Activatable
{
    use ActiveState, HasFactory, Rememberable;

    protected $guarded = [];

    protected $rememberableKeys = ['id', 'name', 'abbreviation'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function localities()
    {
        return $this->hasMany(Locality::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
