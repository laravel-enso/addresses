<?php

namespace LaravelEnso\Addresses\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Sector extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => "Sector {$this->name}",
        ];
    }
}
