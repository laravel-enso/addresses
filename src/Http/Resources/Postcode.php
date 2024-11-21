<?php

namespace LaravelEnso\Addresses\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Postcode extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'country_id' => $this->country_id,
            'region_id' => $this->region_id,
            'locality_id' => $this->locality_id,
            'sector_id' => $this->sector_id,
            'city' => $this->city,
            'street' => $this->street(),
            'lat' => $this->lat,
            'long' => $this->long,
        ];
    }
}
