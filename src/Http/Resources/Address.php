<?php

namespace LaravelEnso\Addresses\Http\Resources;

class Address extends OneLiner
{
    public function toArray($request)
    {
        return parent::toArray($request) + [
            'country' => $this->relationLoaded('country') ? $this->country->name : null,
            'region' => $this->relationLoaded('region') ? $this->region?->name : null,
            'locality' => $this->relationLoaded('locality') ? $this->locality?->name : null,
            'city' => $this->city,
            'street' => $this->street,
            'additional' => $this->resource->additional,
            'postcode' => $this->postcode,
            'notes' => $this->notes,
            'lat' => $this->lat,
            'long' => $this->long,
        ];
    }
}
