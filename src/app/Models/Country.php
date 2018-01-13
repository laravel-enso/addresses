<?php

namespace LaravelEnso\AddressesManager\app\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['isocode_2', 'isocode_3', 'name'];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
