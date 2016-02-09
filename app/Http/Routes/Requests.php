<?php

Route::get('requests', 				'RequestController@index');
Route::get('request', 				'RequestController@request');
Route::post('requests/create', 		'RequestController@create');
Route::get('request/{id}/edit', 	'RequestController@edit');
Route::post('request/{id}/edit', 	'RequestController@save');
Route::get('request/{id}/delete', 	'RequestController@delete');
Route::post('data/requests/db', 	'RequestController@db');
