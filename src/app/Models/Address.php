<?php

namespace LaravelEnso\AddressesManager\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\ActivityLog\app\Traits\LogActivity;
use LaravelEnso\AddressesManager\app\Classes\ConfigMapper;

class Address extends Model
{
    use LogActivity;

    protected $guarded = [];

    protected $casts = ['is_default' => 'boolean'];

    protected $loggableLabel = 'label';

    protected $loggable = [
        'street', 'number', 'city', 'country_id' => [Country::class, 'name'],
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

    public static function store(array $attributes, array $params)
    {
        $addressable = (new ConfigMapper($params['addressable_type']))
            ->class();

        self::create(
            $attributes + [
                'addressable_id' => $params['addressable_id'],
                'addressable_type' => $addressable,
                'is_default' => $addressable::find($params['addressable_id'])
                    ->addresses()->count() === 0,
            ]
        );
    }

    public function scopeFor($query, array $request)
    {
        $query->whereAddressableId($request['addressable_id'])
            ->whereAddressableType(
                (new ConfigMapper($request['addressable_type']))
                    ->class()
            );
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
