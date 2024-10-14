<?php

namespace LaravelEnso\Addresses\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use LaravelEnso\DynamicMethods\Traits\Abilities;
use LaravelEnso\Helpers\Contracts\Activatable;
use LaravelEnso\Helpers\Traits\ActiveState;
use LaravelEnso\Rememberable\Traits\Rememberable;

class Locality extends Model implements Activatable
{
    use Abilities, ActiveState, HasFactory, Rememberable;

    protected $guarded = [];

    protected $rememberableKeys = ['id', 'name'];

    public function region(): Relation
    {
        return $this->belongsTo(Region::class);
    }

    public function township(): Relation
    {
        return $this->belongsTo(Township::class);
    }

    public function sectors(): Relation
    {
        return $this->hasMany(Sector::class);
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
