<?php

namespace LaravelEnso\Addresses\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\App\Http\Resources\OneLiner;
use LaravelEnso\Addresses\App\Models\Address;
use LaravelEnso\Select\App\Traits\OptionsBuilder;

class Options extends Controller
{
    use OptionsBuilder;

    protected $resource = OneLiner::class;

    protected $queryAttributes = [
        'street', 'additional', 'locality.name', 'region.name',
    ];

    public function query(Request $request)
    {
        $params = json_decode($request->get('customParams'));

        return Address::for($params->addressable_id, $params->addressable_type)
            ->with(['region', 'locality'])
            ->ordered();
    }
}
