<?php
/**
 * Created by PhpStorm.
 * User: mihai
 * Date: 12/5/17
 * Time: 2:59 PM
 */

namespace LaravelEnso\AddressesManager\app\DataTable;


use LaravelEnso\AddressesManager\app\Enums\StreetTypes;
use LaravelEnso\DataTable\app\Classes\TableStructure;

class AddressesTableStructure extends TableStructure
{

    public function __construct()
    {
        $this->data = [
            'tableName'           => __('Addresses'),
            'crtNo'               => __('#'),
            'actionButtons'       => __('Actions'),
            'customActionButtons' => [
                ['class' => 'btn-warning fa fa-pencil-square-o', 'event' => 'edit-address', 'route' => 'addresses.update'],
            ],
            'headerAlign'         => 'center',
            'bodyAlign'           => 'center',
            'enumMappings'             => [
                'street_type' => StreetTypes::class
            ],
            'columns'             => [
                0 => [
                    'label' => __('Priority'),
                    'data'  => 'priority',
                    'name'  => 'addresses.priority',
                ],
                1 => [
                    'label' => __('St.Type'),
                    'data'  => 'street_type',
                    'name'  => 'addresses.street_type',
                ],
                2 => [
                    'label' => __('Street'),
                    'data'  => 'street',
                    'name'  => 'addresses.street',
                ],
                3 => [
                    'label' => __('Number'),
                    'data'  => 'number',
                    'name'  => 'addresses.number',
                ],
                4 => [
                    'label' => __('Building'),
                    'data'  => 'building',
                    'name'  => 'addresses.building',
                ],
                5 => [
                    'label' => __('Entry'),
                    'data'  => 'entry',
                    'name'  => 'addresses.entry',
                ],
                6 => [
                    'label' => __('Floor'),
                    'data'  => 'floor',
                    'name'  => 'addresses.floor',
                ],
                7 => [
                    'label' => __('Apartment'),
                    'data'  => 'apartment',
                    'name'  => 'addresses.apartment',
                ],
                8 => [
                    'label' => __('Sub Administrative Area'),
                    'data'  => 'sub_administrative_area',
                    'name'  => 'addresses.sub_administrative_area',
                ],
                9 => [
                    'label' => __('City'),
                    'data'  => 'city',
                    'name'  => 'addresses.city',
                ],
                10 => [
                    'label' => __('Administrative Area'),
                    'data'  => 'administrative_area',
                    'name'  => 'addresses.administrative_area',
                ],
                11 => [
                    'label' => __('Postal Area'),
                    'data'  => 'postal_area',
                    'name'  => 'addresses.postal_area',
                ],
                12 => [
                    'label' => __('Country'),
                    'data'  => 'country',
                    'name'  => 'countries.name',
                ],
                13 => [
                    'label' => __('Observations'),
                    'data'  => 'obs',
                    'name'  => 'addresses.obs',
                ],
            ],
        ];
    }
}