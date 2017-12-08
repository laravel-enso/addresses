<?php
/**
 * Created by PhpStorm.
 * User: mihai
 * Date: 12/7/17
 * Time: 3:51 PM
 */

namespace LaravelEnso\AddressesManager\app\Models;


use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    protected $fillable = ['isocode_2', 'isocode_3', 'name'];

    public function addresses() {
        return $this->hasMany(Address::class);
    }
}