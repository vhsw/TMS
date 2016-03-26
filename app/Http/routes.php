<?php

Route::group(['middleware' => ['web']], function () {
	//Route::auth();
	Route::post('login',						'Auth\AuthController@postLogin');
	Route::get('logout',						'Auth\AuthController@logout');

	Route::get('/', 							'DashboardController@index');
	Route::get('statistic/budget', 				'StatisticController@chartBudget');		// return Json
	Route::post('resource/change', 				'ResourceController@change');
	Route::get('system/setnotificationasread', 'SystemController@setAsRead');	// AJAX

	require(__DIR__ . "/Routes/Inventory.php");

	Route::group(['middleware' => ['auth']], function () {
		require(__DIR__ . "/Routes/Transaction.php");
	});


	Route::group(['middleware' => 'role:admin'], function() {
		require(__DIR__ . "/Routes/Data.php");
		require(__DIR__ . "/Routes/System.php");
		require(__DIR__ . "/Routes/Report.php");

		Route::get('tool/{id}/edit', 			'ToolController@edit');
		Route::get('tool/{id}/save', 			'ToolController@save');

		// For testing
		Route::get('test', 'DashboardController@test');
	});
});
