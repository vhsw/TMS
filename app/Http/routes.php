<?php

get('/', 'DashboardController@index');
get('auth/login', 'Auth\AuthController@getLogin');
post('auth/login', 'Auth\AuthController@postLogin');


Route::group(['middleware' => 'auth'], function () {
	get('auth/logout', 'Auth\AuthController@getLogout');
	get('auth/returnAjax', 'Auth\AuthController@returnAjax'); // AJAX -> JSON
	post('resource/change', 'ResourceController@change'); // AJAX
	require(__DIR__ . "/Routes/Tool.php");

	Route::group(['prefix' => 'admin', 'middleware' => 'role:admin'], function() {
		require(__DIR__ . "/Routes/Data.php");
	});
});