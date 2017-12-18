<?php

Route::middleware(['web', 'auth', 'core'])
    ->prefix('api')
    ->namespace('LaravelEnso\AddressesManager\app\Http\Controllers')
    ->group(function () {
        Route::prefix('addresses')->as('addresses.')->group(function () {
            Route::get('{address}/edit', 'AddressesController@getEditForm')->name('edit');
            Route::get('create', 'AddressesController@getCreateForm')->name('create');
            Route::get('list', 'AddressesController@list')->name('list');
            Route::get('setDefault/{address}', 'AddressesController@setDefault')->name('setDefault');
        });

        Route::resource('addresses', 'AddressesController',
            ['except' => ['show', 'edit', 'create', 'index']]);

        Route::prefix('countries')->as('countries.')->group(function () {
            Route::get('getOptionList', 'CountriesSelectController@getOptionList')->name('getOptionList');
        });
    });
