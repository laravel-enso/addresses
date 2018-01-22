<?php

Route::middleware(['web', 'auth', 'core'])
    ->prefix('api/core')->as('core.')
    ->namespace('LaravelEnso\AddressesManager\app\Http\Controllers')
    ->group(function () {
        Route::resource('addresses', 'AddressesController', ['except' => ['show']]);
        Route::patch('addressess/setDefault/{address}', 'AddressesController@setDefault')->name('addresses.setDefault');
        Route::get('addresses/countriesSelectOptions', 'CountriesSelectController@options')->name('addresses.countriesSelectOptions');
    });
