<?php

namespace LaravelEnso\Addresses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEnso\Helpers\Traits\TransformMorphMap;

class ValidateAddressFetch extends FormRequest
{
    use TransformMorphMap;

    public function morphType(): string
    {
        return 'addressable_type';
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'addressable_id' => 'required',
            'addressable_type' => 'required|string',
        ];
    }
}
