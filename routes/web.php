<?php

Route::get('/', ['as' => 'index', 'uses' => 'HomeController@index']);
Route::name('user-change-password')->get('/auth/password/user-change/{user}', 'UsersController@changePasswordForm');
Route::name('user-update-password')->post('/auth/password/user-update/{user}', 'UsersController@changePassword');
Route::name('customer-change-password')->get('/auth/password/customer-change/{customer}', 'CustomersController@changePasswordForm');
Route::name('customer-update-password')->post('/auth/password/customer-update/{customer}', 'CustomersController@changePassword');

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth:user,customer']], function() {

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/toggle-boolean', ['as' => 'toggle-boolean', 'uses' => 'CommonController@toggleBoolean']);
    Route::get('/permissions-toggle', ['as' => 'toggle-boolean', 'uses' => 'CommonController@togglePermissions']);
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth:user']], function() {

    Route::name('activity-logs')->get('/activity-logs', 'ActivityLogController@index')->middleware('admin');
    Route::name('activity-logs.show')->get('/activity-logs/show/{activity}', 'ActivityLogController@show')->middleware('admin');

    Route::name('users')->get('/users', 'UsersController@index')->middleware('admin');
    Route::name('users.create')->get('/users/create', 'UsersController@create')->middleware('admin');
    Route::name('users.store')->post('/users/store', 'UsersController@store')->middleware('admin');
    Route::name('users.edit')->get('/users/{user}/edit', 'UsersController@edit')->middleware('admin');
    Route::name('users.update')->post('/users/{user}/update', 'UsersController@update')->middleware('admin');
    Route::name('users.delete')->post('/users/{user}/delete', 'UsersController@destroy')->middleware('admin');
});
