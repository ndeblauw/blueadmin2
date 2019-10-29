<?php

Route::group(['prefix' => 'admin', 'middleware' => ['web','auth']], function () {
	Route::get('', 'Ndeblauw\BlueAdmin\BlueAdminController@dashboard')->name('blueadmin.dashboard');
	Route::get('{modelname}', 'Ndeblauw\BlueAdmin\BlueAdminController@index')->name('blueadmin.index');
	Route::get('{modelname}/create', 'Ndeblauw\BlueAdmin\BlueAdminController@create')->name('blueadmin.create');
	Route::post('{modelname}', 'Ndeblauw\BlueAdmin\BlueAdminController@store')->name('blueadmin.store');
	Route::get('{modelname}/{id}/edit', 'Ndeblauw\BlueAdmin\BlueAdminController@edit')->name('blueadmin.edit');
	Route::put('{modelname}/{id}', 'Ndeblauw\BlueAdmin\BlueAdminController@update')->name('blueadmin.update');
	Route::delete('{modelname}/{id}', 'Ndeblauw\BlueAdmin\BlueAdminController@destroy')->name('blueadmin.destroy');
});
