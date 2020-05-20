<?php

namespace LaravelEnso\Addresses\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Address extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'country' => $this->country->name,
            'region' => optional($this->region)->name,
            'locality' => optional($this->locality)->name,
            'city' => $this->city,
            'street' => $this->street,
            'additional' => $this->resource->additional,
            'postalArea' => $this->postal_area,
            'obs' => $this->obs,
            'isDefault' => $this->is_default,
        ];
    }
}
