<?php

Route::group(['middleware' => ['web']], function () {
	Route::auth();

	Route::get('/', 'DashboardController@index');
	Route::post('resource/change', 'ResourceController@change');
	require(__DIR__ . "/Routes/Tool.php");

	Route::group(['middleware' => ['auth']], function () {
		require(__DIR__ . "/Routes/Requests.php");
	});


	Route::group(['middleware' => 'role:admin'], function() {
		require(__DIR__ . "/Routes/Data.php");
		require(__DIR__ . "/Routes/System.php");

		Route::get('tool/{id}/edit', 			'ToolController@edit');
		Route::get('tool/{id}/save', 			'ToolController@save');
	});
});


