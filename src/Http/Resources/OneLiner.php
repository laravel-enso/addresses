<?php

namespace LaravelEnso\Addresses\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OneLiner extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'label' => $this->relationLoaded('region') && $this->relationLoaded('locality')
                ? $this->label()
                : null,
            'is_billing' => $this->is_billing,
            'is_shipping' => $this->is_shipping,
        ];
    }
}
