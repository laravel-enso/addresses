<?php

namespace LaravelEnso\AddressesManager\app\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $guarded = [];

    protected $casts = ['is_default' => 'boolean'];

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
        \DB::transaction(function () {
            $this->addressable->addresses()
                ->whereIsDefault(true)
                ->update(['is_default' => false]);

            $this->update(['is_default' => true]);
        });
    }

    public function scopeDefault($query)
    {
        $query->whereIsDefault(true);
    }

    public function scopeFor($query, array $params)
    {
        $query->whereAddressableId($params['addressable_id'])
            ->whereAddressableType($params['addressable_type']);
    }

    public function scopeOrdered($query)
    {
        $query->orderByDesc('is_default');
    }

    public function getLoggableMorph()
    {
        return config('enso.addresses.loggableMorph');
    }
}
