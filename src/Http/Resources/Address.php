<?php

namespace LaravelEnso\Addresses\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Address extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'country' => $this->relationLoaded('country') ? $this->country->name : null,
            'region' => $this->relationLoaded('region') ? optional($this->region)->name : null,
            'locality' => $this->relationLoaded('locality') ? optional($this->locality)->name : null,
            'city' => $this->city,
            'street' => $this->street,
            'additional' => $this->resource->additional,
            'postcode' => $this->postcode,
            'notes' => $this->notes,
            'isDefault' => $this->is_default,
        ];
    }
}
