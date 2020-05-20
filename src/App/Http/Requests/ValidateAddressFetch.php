<?php

namespace LaravelEnso\Addresses\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelEnso\Helpers\App\Contracts\TransformsMorphMap;
use LaravelEnso\Helpers\App\Traits\TransformMorphMap;

class ValidateAddressFetch extends FormRequest implements TransformsMorphMap
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
