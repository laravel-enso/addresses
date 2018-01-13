<?php

namespace LaravelEnso\AddressesManager\app\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\TrackWho\app\Traits\CreatedBy;

class Address extends Model
{
    use CreatedBy;

    protected $fillable = [
        'country_id', 'type', 'is_default', 'street', 'street_type', 'number', 'building',
        'entry', 'floor', 'apartment', 'sub_administrative_area', 'city', 'administrative_area',
        'postal_area', 'obs',
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

    public function getOwnerAttribute()
    {
        $owner = [
            'fullName' => $this->user->fullName,
            'avatarId' => $this->user->avatarId,
        ];

        unset($this->user);

        return $owner;
    }
}
