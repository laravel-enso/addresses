<?php

Route::middleware(['web', 'auth', 'core'])
    ->prefix('api/core/addresses')->as('core.addresses.')
    ->namespace('LaravelEnso\Addresses\app\Http\Controllers')
    ->group(function () {
        Route::get('', 'Index')->name('index');
        Route::get('create', 'Create')->name('create');
        Route::post('', 'Store')->name('store');
        Route::get('{address}/edit', 'Edit')->name('edit');
        Route::patch('{address}', 'Update')->name('update');
        Route::delete('{address}', 'Destroy')->name('destroy');

        Route::patch('makeDefault/{address}', 'MakeDefault')->name('makeDefault');
    });
