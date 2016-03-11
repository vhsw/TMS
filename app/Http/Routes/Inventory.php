<?php

Route::get('inventory/search/', 				'InventoryController@search');
Route::get('inventory/search/result', 			'InventoryController@result');
Route::get('inventory/browse', 				       'InventoryController@index');

Route::get('inventory/{item}/view', 			'InventoryController@view');
Route::get('inventory/new', 				    'InventoryController@new');
Route::post('inventory/create', 				'InventoryController@create');
Route::get('inventory/{item}/edit', 			'InventoryController@edit');
Route::get('inventory/{item}/save', 			'InventoryController@save');
Route::get('inventory/{item}/request', 			'InventoryController@request');

Route::post('inventory/db', 					'InventoryController@db');	// AJAX
Route::get('inventory/typeahead', 				'InventoryController@typeahead'); // AJAX
Route::get('inventory/barcode', 				'InventoryController@barcode'); // AJAX

//post('plugins/download', 					'Plugins\CurlController@index');
Route::get('plugins/download', 				'Plugins\CurlController@index');
Route::get('plugins/download/save', 		'ToolController@savetoolinfo');

Route::get('data/categories/children', 	'CategoryController@children'); // AJAX
