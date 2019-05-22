<?php

Route::group([
        'middleware' => [
            'web', 'rb28dett.base', 'rb28dett.auth',
            'can:access,RB28DETT\Permissions\Models\Permission',
        ],
        'prefix'    => config('rb28dett.settings.base_url'),
        'namespace' => 'RB28DETT\Permissions\Controllers',
        'as'        => 'rb28dett::',
    ], function () {
        Route::get('permissions/{permission}/delete', 'PermissionController@confirmDelete')->name('permissions.destroy.confirm');
        Route::resource('permissions', 'PermissionController', ['except' => ['show']]);
    });
