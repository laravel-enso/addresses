<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'core'])
    ->prefix('api/core/addresses')->as('core.addresses.')
    ->namespace('LaravelEnso\Addresses\App\Http\Controllers')
    ->group(function () {
        Route::get('localities', 'Localities')->name('localities');
        Route::get('regions', 'Regions')->name('regions');
        Route::get('', 'Index')->name('index');
        Route::get('create', 'Create')->name('create');
        Route::post('', 'Store')->name('store');
        Route::get('options', 'Options')->name('options');
        Route::get('{address}/edit', 'Edit')->name('edit');
        Route::get('{address}/localize', 'Localize')->name('localize');
        Route::patch('{address}', 'Update')->name('update');
        Route::delete('{address}', 'Destroy')->name('destroy');

        Route::patch('makeDefault/{address}', 'MakeDefault')->name('makeDefault');
    });
