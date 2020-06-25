<?php

namespace LaravelEnso\Addresses\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Helpers\Contracts\Activatable;
use LaravelEnso\Helpers\Traits\ActiveState;

class Region extends Model implements Activatable
{
    use ActiveState;

    protected $guarded = ['id'];

    public function localities()
    {
        return $this->hasMany(Locality::class);
    }
}
