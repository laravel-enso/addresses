<?php

namespace LaravelEnso\Addresses\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Countries\Models\Country;

class Postcode extends Model
{
    protected $guarded = [];

    public function township()
    {
        return $this->belongsTo(Township::class);
    }

    public function locality()
    {
        return $this->belongsTo(Locality::class);
    }

    public function county()
    {
        return $this->belongsTo(County::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function scopeFor(Builder $builder, int $countryId, string $code): Builder
    {
        return $builder->whereCountryId($countryId)
            ->whereCode($code);
    }
}
