<?php

namespace LaravelEnso\AddressesManager\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Address extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'country' => optional($this->country)->name,
            'administrativeArea' => $this->administrative_area,
            'city' => $this->city,
            'subAdministrativeArea' => $this->sub_administrative_area,
            'streetType' => $this->street_type,
            'street' => $this->street,
            'number' => $this->number,
            'building' => $this->building,
            'entry' => $this->entry,
            'floor' => $this->floor,
            'apartment' => $this->apartment,
            'buildingType' => $this->building_type,
            'postalArea' => $this->postal_area,
            'obs' => $this->obs,
            'isDefault' => $this->is_default,
        ];
    }
}
