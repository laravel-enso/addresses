<?php

namespace LaravelEnso\Addresses\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Region extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
