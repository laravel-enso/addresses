<?php

Route::middleware(['web', 'auth', 'core'])
    ->prefix('api')
    ->namespace('LaravelEnso\AddressesManager\app\Http\Controllers')
    ->group(function () {
        Route::resource('addresses', 'AddressesController', ['except' => ['show']]);
        Route::patch('addresses.setDefault/{address}', 'AddressesController@setDefault')->name('addresses.setDefault');
        Route::get('addresses.getCountryList', 'CountriesSelectController@getOptionList')->name('addresses.getCountryList');
    });
