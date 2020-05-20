<?php

namespace LaravelEnso\Addresses\App\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Helpers\App\Contracts\Activatable;
use LaravelEnso\Helpers\App\Traits\ActiveState;

class Locality extends Model implements Activatable
{
    use ActiveState;

    protected $fillable = [
        'region_id', 'name', 'township', 'siruta', 'lat', 'long', 'is_active',
    ];

    protected $appends = ['label'];

    protected $casts = ['is_active' => 'boolean'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function getLabelAttribute()
    {
        $label = $this->siruta
            ? $this->name.' - '.$this->siruta
            : $this->name;

        return $this->township
            ? $label.' ('.$this->township.')'
            : $label;
    }
}
