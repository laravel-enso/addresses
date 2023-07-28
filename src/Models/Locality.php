<?php

namespace LaravelEnso\Addresses\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\DynamicMethods\Traits\Abilities;
use LaravelEnso\Helpers\Contracts\Activatable;
use LaravelEnso\Helpers\Traits\ActiveState;
use LaravelEnso\Rememberable\Traits\Rememberable;

class Locality extends Model implements Activatable
{
    use Abilities, ActiveState, HasFactory, Rememberable;

    protected $guarded = [];

    protected $casts = ['is_active' => 'boolean'];

    protected $rememberableKeys = ['id', 'name'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function township()
    {
        return $this->belongsTo(Township::class);
    }
}
