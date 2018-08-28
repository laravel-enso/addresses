<?php

namespace LaravelEnso\AddressesManager\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use LaravelEnso\Helpers\app\Classes\ResourceAttributeMapper;

class Address extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'      => $this->id,
            'country' => $this->whenLoaded('country', $this->country->name),
        ] +
        (new ResourceAttributeMapper(
            $this,
            config('enso.addresses.resource')
        ))->get();
    }
}
