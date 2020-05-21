<?php

namespace LaravelEnso\Addresses\App\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Helpers\App\Contracts\Activatable;
use LaravelEnso\Helpers\App\Traits\ActiveState;

class Region extends Model implements Activatable
{
    use ActiveState;

    protected $fillable = ['country_id', 'abbreviation', 'name'];

    public function localities()
    {
        return $this->hasMany(Locality::class);
    }
}
