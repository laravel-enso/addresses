<?php

namespace LaravelEnso\Addresses\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\App\Http\Requests\ValidateWriteRequest;
use LaravelEnso\Addresses\app\Models\Address;

class Store extends Controller
{
    public function __invoke(ValidateWriteRequest $request)
    {
        \Log::info($request->validated());
        Address::create($request->validated());

        return [
            'message' => __('The address was successfully created'),
        ];
    }
}
