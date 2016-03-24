<?php

Route::get('inventory/search/', 				'InventoryController@search');
Route::get('inventory/search/result', 			'InventoryController@result');
Route::get('inventory/browse', 				    'InventoryController@index');

Route::get('inventory/{item}/view', 			'InventoryController@view');
Route::get('inventory/new', 				    'InventoryController@new');
Route::post('inventory/create', 				'InventoryController@create');
Route::get('inventory/{item}/edit', 			'InventoryController@edit');
Route::get('inventory/{item}/save', 			'InventoryController@save');
Route::get('inventory/{item}/request', 			'InventoryController@request');

Route::get('inventory/instant-search-barcode',  'InventoryController@instantSearchBarcode'); // AJAX
Route::get('inventory/instant-search-serialnr', 'InventoryController@instantSearchSerialnr'); // AJAX
Route::get('inventory/instant-item-serialnr', 	'InventoryController@getInventoryBySerialnr'); // AJAX
Route::get('inventory/{item}/change-supplier',  'SupplierController@changeSupplier'); // AJAX
Route::post('inventory/db', 					'InventoryController@db');	// AJAX
Route::get('inventory/barcode', 				'InventoryController@barcode'); // AJAX
Route::get('inventory/{item}/generateSku', 		'InventoryController@generateSku'); // AJAX
Route::get('inventory/download', 				'Plugins\CurlController@index'); // AJAX

Route::get('plugins/download/save', 		    'ToolController@savetoolinfo');

Route::get('data/categories/children', 	        'CategoryController@children'); // AJAX
