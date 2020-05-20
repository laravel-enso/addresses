<?php

namespace LaravelEnso\Addresses\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OneLiner extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'label' => $this->whenRelationsLoaded()
                ? $this->label
                : '',
        ];
    }

    private function whenRelationsLoaded()
    {
        return $this->relationLoaded('country')
            && $this->relationLoaded('region')
            && $this->relationLoaded('locality');
    }
}
