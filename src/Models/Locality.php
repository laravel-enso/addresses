<?php

namespace LaravelEnso\Addresses\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Helpers\Contracts\Activatable;
use LaravelEnso\Helpers\Traits\ActiveState;
use LaravelEnso\Rememberable\Traits\Rememberable;

class Locality extends Model implements Activatable
{
    use ActiveState, HasFactory, Rememberable;

    protected $guarded = ['id'];

    protected $appends = ['label'];

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

    public function getLabelAttribute()
    {
        return $this->township_id
            ? $this->name.' ('.$this->township->name.')'
            : $this->name;
    }
}
