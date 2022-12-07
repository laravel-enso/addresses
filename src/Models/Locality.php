<?php

namespace LaravelEnso\Addresses\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Helpers\Contracts\Activatable;
use LaravelEnso\Helpers\Traits\ActiveState;
use LaravelEnso\Rememberable\Traits\Rememberable;

class Locality extends Model implements Activatable
{
    use ActiveState;
    use HasFactory;
    use Rememberable;

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
