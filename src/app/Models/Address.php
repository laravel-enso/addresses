<?php

namespace LaravelEnso\AddressesManager\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\ActivityLog\app\Traits\LogsActivity;

class Address extends Model
{
    use LogsActivity;

    protected $guarded = [];

    protected $casts = ['is_default' => 'boolean'];

    protected $loggableLabel = 'label';

    protected $loggable = [
        'street', 'number', 'city', 'country_id' => [Country::class => 'name'],
    ];

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
                $this->country->name,
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
                ->get()
                ->each
                ->update(['is_default' => false]);

            $this->update(['is_default' => true]);
        });
    }

    public function scopeFor($query, array $params)
    {
        $query->whereAddressableId($params['addressable_id'])
            ->whereAddressableType($params['addressable_type']);
    }

    public function scopeOrdered($query)
    {
        $query->orderBy('is_default', 'desc');
    }

    public function getLoggableMorph()
    {
        return config('enso.addresses.loggableMorph');
    }
}
