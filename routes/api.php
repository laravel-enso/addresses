<?php

use Illuminate\Support\Facades\Route;
use LaravelEnso\Addresses\Http\Controllers\Localities;
use LaravelEnso\Addresses\Http\Controllers\Regions;
use LaravelEnso\Addresses\Http\Controllers\Index;
use LaravelEnso\Addresses\Http\Controllers\Create;
use LaravelEnso\Addresses\Http\Controllers\Store;
use LaravelEnso\Addresses\Http\Controllers\Options;
use LaravelEnso\Addresses\Http\Controllers\Postcode;
use LaravelEnso\Addresses\Http\Controllers\Edit;
use LaravelEnso\Addresses\Http\Controllers\Localize;
use LaravelEnso\Addresses\Http\Controllers\Update;
use LaravelEnso\Addresses\Http\Controllers\Destroy;
use LaravelEnso\Addresses\Http\Controllers\Show;
use LaravelEnso\Addresses\Http\Controllers\MakeDefault;
use LaravelEnso\Addresses\Http\Controllers\MakeBilling;
use LaravelEnso\Addresses\Http\Controllers\MakeShipping;


Route::middleware(['api', 'auth', 'core'])
    ->prefix('api/core/addresses')->as('core.addresses.')
    ->group(function () {
        Route::get('localities', Localities::class)->name('localities');
        Route::get('regions', Regions::class)->name('regions');
        Route::get('', Index::class)->name('index');
        Route::get('create', Create::class)->name('create');
        Route::post('', Store::class)->name('store');
        Route::get('options', Options::class)->name('options');
        Route::get('postcode', Postcode::class)->name('postcode');
        Route::get('{address}/edit', Edit::class)->name('edit');
        Route::get('{address}/localize', Localize::class)->name('localize');
        Route::patch('{address}', Update::class)->name('update');
        Route::delete('{address}', Destroy::class)->name('destroy');

        Route::patch('makeDefault/{address}', MakeDefault::class)->name('makeDefault');
        Route::patch('makeBilling/{address}', MakeBilling::class)->name('makeBilling');
        Route::patch('makeShipping/{address}', MakeShipping::class)->name('makeShipping');

        Route::get('{address}', Show::class)->name('show');
    });
