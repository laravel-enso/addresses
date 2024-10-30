<?php

namespace LaravelEnso\Addresses\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Rememberable\Traits\Rememberable;

class Sector extends Model
{
    use Rememberable;

    protected $guarded = [];
}
