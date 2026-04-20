<?php

namespace LaravelEnso\Addresses\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OneLiner extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'label'      => $this->label(),
            'isDefault'  => $this->is_default,
            'isBilling'  => $this->is_billing,
            'isShipping' => $this->is_shipping,
        ];
    }

    private function label(): ?string
    {
        return $this->relationLoaded('region')
            && $this->relationLoaded('locality')
            ? $this->resource->label()
            : null;
    }
}
