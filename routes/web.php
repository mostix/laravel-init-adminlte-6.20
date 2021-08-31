<?php

Route::name('index')->get('/', 'HomeController@index');
Route::name('user-change-password')->get('/auth/password/user-change/{user}', 'Admin\UsersController@changePasswordForm');
Route::name('user-update-password')->post('/auth/password/user-update/{user}', 'Admin\UsersController@changePassword');

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth:web']], function() {

    Route::name('home')->get('/home', 'HomeController@index');
    Route::name('toggle-boolean')->get('/toggle-boolean', 'CommonController@toggleBoolean');
    Route::name('toggle-permissions')->get('/toggle-permissions', 'CommonController@togglePermissions');
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth:web']], function() {

    Route::name('activity-logs')->get('/activity-logs', 'ActivityLogController@index')->middleware('admin');
    Route::name('activity-logs.show')->get('/activity-logs/show/{activity}', 'ActivityLogController@show')->middleware('admin');

    Route::name('users')->get('/users', 'UsersController@index')->middleware('admin');
    Route::name('users.create')->get('/users/create', 'UsersController@create')->middleware('admin');
    Route::name('users.store')->post('/users/store', 'UsersController@store')->middleware('admin');
    Route::name('users.edit')->get('/users/{user}/edit', 'UsersController@edit')->middleware('admin');
    Route::name('users.update')->post('/users/{user}/update', 'UsersController@update')->middleware('admin');
    Route::name('users.delete')->post('/users/{user}/delete', 'UsersController@destroy')->middleware('admin');

    Route::name('roles')->get('/roles', 'RolesController@index')->middleware('admin');
    Route::name('roles.create')->get('/roles/create', 'RolesController@create')->middleware('admin');
    Route::name('roles.store')->post('/roles/store', 'RolesController@store')->middleware('admin');
    Route::name('roles.edit')->get('/roles/{role}/edit', 'RolesController@edit')->middleware('admin');
    Route::name('roles.update')->post('/roles/{role}/update', 'RolesController@update')->middleware('admin');
    Route::name('roles.delete')->post('/roles/{role}/delete', 'RolesController@destroy')->middleware('admin');
});
