<?php

namespace LaravelEnso\Addresses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateCoordinates extends FormRequest
{
    public function rules()
    {
        \Log::info($this->get('lat'));

        return [
            'lat' => new Latitude(),
            'long' => new Longitude(),
        ];
    }
}
