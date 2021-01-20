<?php

namespace LaravelEnso\Addresses\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Helpers\Contracts\Activatable;
use LaravelEnso\Helpers\Traits\ActiveState;

class Locality extends Model implements Activatable
{
    use ActiveState, HasFactory;

    protected $guarded = ['id'];

    protected $appends = ['label'];

    protected $casts = ['is_active' => 'boolean'];

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
