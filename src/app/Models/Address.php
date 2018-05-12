<?php

namespace LaravelEnso\AddressesManager\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\TrackWho\app\Traits\CreatedBy;
use LaravelEnso\AddressesManager\app\Classes\ConfigMapper;

class Address extends Model
{
    use CreatedBy;

    protected $fillable = [
        'addressable_id', 'addressable_type', 'country_id', 'is_default', 'street', 'street_type',
        'number', 'building_type', 'building', 'entry', 'floor', 'apartment', 'sub_administrative_area',
        'city', 'administrative_area', 'postal_area', 'obs',
    ];

    protected $appends = ['country_name'];

    protected $casts = ['is_default' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'created_by', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function addressable()
    {
        return $this->morphTo();
    }

    public function getCountryNameAttribute()
    {
        return $this->country->name;
    }

    public function getCreatorAttribute()
    {
        $owner = [
            'fullName' => $this->user->fullName,
            'avatarId' => $this->user->avatarId,
        ];

        unset($this->user);

        return $owner;
    }

    public function setDefault()
    {
        \DB::transaction(function () {
            $this->addressable->addresses()
                ->whereIsDefault(true)
                ->get()->each
                ->update(['is_default' => false]);

            $this->update(['is_default' => true]);
        });
    }

    public function store(array $attributes, array $params)
    {
        $addressable = (new ConfigMapper($params['type']))
            ->class();

        $this->fill(
            $attributes + [
                'addressable_id' => $params['id'],
                'addressable_type' => $addressable,
            ]
        );

        $this->is_default = $addressable::find($params['id'])
            ->addresses()->count() === 0;

        $this->save();
    }

    public function scopeFor($query, array $request)
    {
        $query->whereAddressableId($request['id'])
            ->whereAddressableType(
                (new ConfigMapper($request['type']))->class()
            );
    }
}
