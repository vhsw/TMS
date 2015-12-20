<?php

get('/', 'DashboardController@index');
get('auth/login', 'Auth\AuthController@getLogin');
post('auth/login', 'Auth\AuthController@postLogin');


Route::group(['middleware' => 'auth'], function () {
	get('auth/logout', 'Auth\AuthController@getLogout');
	get('auth/returnAjax', 'Auth\AuthController@returnAjax'); // AJAX -> JSON
	post('resource/change', 'ResourceController@change'); // AJAX

	require(__DIR__ . "/Routes/Tool.php");
});

Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function() {
	require(__DIR__ . "/Routes/Data.php");
});

/*
$router->group(['namespace' => 'Backend'], function () use ($router)
{
	$router->group(['prefix' => 'admin', 'middleware' => 'auth'], function () use ($router)
	{
		/**
		 * These routes need view-backend permission (good if you want to allow more than one group in the backend, then limit the backend features by different roles or permissions)
		 *
		 * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
		 *
		$router->group(['middleware' => 'access.routeNeedsPermission:view-backend'], function () use ($router)
		{
			require(__DIR__ . "/Routes/Backend/Dashboard.php");
			require(__DIR__ . "/Routes/Backend/Access.php");
			require(__DIR__ . "/Routes/Backend/Data.php");
			require(__DIR__ . "/Routes/Backend/System.php");

			get('data/resources', 'ResourceController@index');

		});
	});
}); */


/*

$router->group(['namespace' => 'Frontend', 'middleware' => 'access.routeNeedsPermission:view-backend'], function () use ($router)
{
	get('admin/data/resources', 'ResourceController@index');
	post('admin/data/resources/db', 'ResourceController@db');		
}); */