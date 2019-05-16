<?php

namespace LaravelEnso\Addresses\app\Http\Controllers;

use Illuminate\Routing\Controller;
use LaravelEnso\Addresses\app\Models\Address;
use LaravelEnso\Addresses\App\Http\Requests\ValidateCommentWrite;

class Update extends Controller
{
    public function __invoke(ValidateCommentWrite $request, Address $address)
    {
        $address->update($request->validated());

        return [
            'message' => __('The address have been successfully updated'),
        ];
    }
}
