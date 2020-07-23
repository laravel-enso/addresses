<?php

namespace LaravelEnso\Addresses\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Postcode extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'country_id' => $this->country_id,
            'region_id' => $this->region_id,
            'code' => $this->code,
            'lat' => $this->lat,
            'long' => $this->long,
        ];
    }
}
