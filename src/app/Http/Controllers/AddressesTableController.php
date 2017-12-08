<?php

namespace LaravelEnso\AddressesManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use LaravelEnso\AddressesManager\app\DataTable\AddressesTableStructure;
use LaravelEnso\AddressesManager\app\Models\Address;
use LaravelEnso\DataTable\app\Traits\DataTable;

class AddressesTableController extends Controller
{
    use DataTable;

    protected $tableStructureClass = AddressesTableStructure::class;

    public static function getTableQuery()
    {
        return Address::select(DB::raw('addresses.id as DT_RowId,
            type, priority, apartment, floor, entry, building, number, street, street_type,
            sub_administrative_area, city, administrative_area, postal_area, obs,
            countries.name as country
        '))
            ->join('countries', 'addresses.country_id', '=', 'countries.id');
    }
}
