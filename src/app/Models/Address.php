<?php

namespace LaravelEnso\Addresses\app\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Helpers\app\Traits\UpdatesOnTouch;
use Illuminate\Database\Eloquent\Relations\Relation;

class Address extends Model
{
    use UpdatesOnTouch;

    protected $fillable = [
        'addressable_id', 'addressable_type', 'country_id', 'is_default',
        'apartment', 'floor', 'entry', 'building', 'building_type',
        'number', 'street', 'street_type', 'sub_administrative_area', 'city',
        'administrative_area', 'postal_area', 'obs', 'lat', 'long',
    ];

    protected $casts = ['is_default' => 'boolean'];

    protected $touches = ['addressable'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function addressable()
    {
        return $this->morphTo();
    }

    public function getLabelAttribute()
    {
        $label = collect([
            trim($this->number.' '.$this->street),
            $this->city,
            optional($this->country)->name,
        ])->filter()
        ->implode(', ');

        unset($this->country);

        return $label;
    }

    public function setDefault()
    {
        DB::transaction(function () {
            $this->addressable->addresses()
                ->whereIsDefault(true)
                ->update(['is_default' => false]);

            $this->update(['is_default' => true]);
        });
    }

    public function isDefault()
    {
        return $this->is_default;
    }

    public function scopeDefault($query)
    {
        return $query->whereIsDefault(true);
    }

    public function scopeNotDefault($query)
    {
        return $query->whereIsDefault(false);
    }

    public function scopeFor($query, array $params)
    {
        $params['addressable_type'] = Relation::getMorphedModel($params['addressable_type'])
            ?? $params['addressable_type'];

        return $query->whereAddressableId($params['addressable_id'])
            ->whereAddressableType($params['addressable_type']);
    }

    public function scopeOrdered($query)
    {
        return $query->orderByDesc('is_default');
    }

    public function getLoggableMorph()
    {
        return config('enso.addresses.loggableMorph');
    }
}
