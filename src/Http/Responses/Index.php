<?php

namespace LaravelEnso\Addresses\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use LaravelEnso\Addresses\Http\Resources\Address as Resource;
use LaravelEnso\Addresses\Models\Address;

class Index implements Responsable
{
    public function toResponse($request)
    {
        return Resource::collection(
            Address::with('country', 'region', 'locality')
                ->for($request->get('addressable_id'), $request->get('addressable_type'))
                ->ordered()
                ->get()
        );
    }
}
