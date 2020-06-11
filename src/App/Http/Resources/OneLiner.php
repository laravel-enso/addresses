<?php

namespace LaravelEnso\Addresses\App\Http\Resources;

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
        ];
    }
}
