<?php

Route::middleware(['web', 'auth', 'core'])
    ->namespace('LaravelEnso\AddressesManager\app\Http\Controllers')
    ->group(function () {
        Route::prefix('addresses')->as('addresses.')->group(function () {
            Route::get('setDefault/{address}', 'AddressesController@setDefault')->name('setDefault');
            Route::get('countriesSelectOptions', 'CountriesSelectController@getOptionList')
                ->name('countriesSelectOptions');
        });

        Route::resource('addresses', 'AddressesController', ['except' => ['show']]);
    });
