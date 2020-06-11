<?php

namespace LaravelEnso\Addresses\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use LaravelEnso\Countries\App\Models\Country;
use LaravelEnso\Helpers\App\Traits\AvoidsDeletionConflicts;
use LaravelEnso\Helpers\App\Traits\UpdatesOnTouch;
use LaravelEnso\Rememberable\App\Traits\Rememberable;

class Address extends Model
{
    use AvoidsDeletionConflicts, UpdatesOnTouch, Rememberable;

    protected $fillable = [
        'addressable_id', 'addressable_type', 'country_id', 'region_id', 'locality_id',
        'city', 'street', 'additional', 'postcode', 'lat', 'long', 'notes', 'is_default',
    ];

    protected $casts = ['is_default' => 'boolean'];

    protected $touches = ['addressable'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function locality()
    {
        return $this->belongsTo(Locality::class);
    }

    public function addressable()
    {
        return $this->morphTo();
    }

    public function isDefault()
    {
        return $this->is_default;
    }

    public function getLocalityNameAttribute()
    {
        return optional($this->locality)->name;
    }

    public function getCountyNameAttribute()
    {
        return optional($this->region)->name;
    }

    public function label()
    {
        $locality = optional($this->locality)->name ?? $this->city;

        return (new Collection([optional($this->region)->name, $locality, $this->street]))
            ->filter()->implode(', ');
    }

    public function scopeDefault($query)
    {
        return $query->whereIsDefault(true);
    }

    public function scopeNotDefault($query)
    {
        return $query->whereIsDefault(false);
    }

    public function scopeFor($query, int $addressable_id, string $addressable_type)
    {
        return $query->whereAddressableId($addressable_id)
            ->whereAddressableType($addressable_type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderByDesc('is_default');
    }

    public function makeDefault()
    {
        DB::transaction(function () {
            $this->addressable->addresses()
                ->whereIsDefault(true)
                ->update(['is_default' => false]);

            $this->update(['is_default' => true]);
        });
    }

    public function getLoggableMorph()
    {
        return config('enso.addresses.loggableMorph');
    }

    public function shouldBeSingle(): bool
    {
        return ! $this->canBeMultiple()
            && $this->addressable->address()->exists();
    }

    public function isNotSingle(): bool
    {
        return $this->canBeMultiple()
            && $this->addressable->address()->where('id', '<>', $this->id)->exists();
    }

    private function canBeMultiple(): bool
    {
        return method_exists($this->addressable, 'addresses');
    }
}
