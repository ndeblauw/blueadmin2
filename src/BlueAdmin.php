<?php

namespace Ndeblauw\BlueAdmin;


use Illuminate\Support\Facades\Route;

class BlueAdmin {

    public static function routes()
    {

        Route::get('', '\Ndeblauw\BlueAdmin\BlueAdminController@dashboard')->name('blueadmin.dashboard');

        // Generic resourceful controller for catch all routes
        Route::get('{modelname}', '\Ndeblauw\BlueAdmin\BlueAdminController@index')->name('blueadmin.index');
        Route::get('{modelname}/create', '\Ndeblauw\BlueAdmin\BlueAdminController@create')->name('blueadmin.create');
        Route::post('{modelname}', '\Ndeblauw\BlueAdmin\BlueAdminController@store')->name('blueadmin.store');
        Route::get('{modelname}/{id}', '\Ndeblauw\BlueAdmin\BlueAdminController@show')->name('blueadmin.show');
        Route::get('{modelname}/{id}/edit', '\Ndeblauw\BlueAdmin\BlueAdminController@edit')->name('blueadmin.edit');
        Route::put('{modelname}/{id}', '\Ndeblauw\BlueAdmin\BlueAdminController@update')->name('blueadmin.update');
        Route::delete('{modelname}/{id}', '\Ndeblauw\BlueAdmin\BlueAdminController@destroy')->name('blueadmin.destroy');
        Route::get('{modelname}/{id}/delete', '\Ndeblauw\BlueAdmin\BlueAdminController@destroy')->name('blueadmin.destroy.get');

        //
        Route::get('api/v1/{modelname}', '\Ndeblauw\BlueAdmin\BlueAdminController@api_index')->name('blueadmin.api.index');

        // Auxiliary routes for blueadmin functionality
        Route::get('blueadmin/toggle-show-delete/{modelname}/', '\Ndeblauw\BlueAdmin\BlueAdminController@toggleShowDelete')->name('blueadmin.index.toggle-show-delete');
        Route::get('blueadmin/toggle-open-new-window/{modelname}', '\Ndeblauw\BlueAdmin\BlueAdminController@toggleOpenNewWindow')->name('blueadmin.index.toggle-open-new-window');
    }
}
