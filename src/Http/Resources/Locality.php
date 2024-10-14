<?php

namespace LaravelEnso\Addresses\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Locality extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name(),
            'locality' => $this->name,
            'hasSectors' => $this->sectors()->exists(),
        ];
    }

    private function name(): string
    {
        return $this->relationLoaded('township') && $this->township
            ? "{$this->name} ({$this->township->name})"
            : $this->name;
    }
}
