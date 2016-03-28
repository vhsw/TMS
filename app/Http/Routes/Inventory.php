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

// AJAX Routes
Route::get('inventory/instant-search-barcode',  'InventoryController@instantSearchBarcode');
Route::get('inventory/instant-search-serialnr', 'InventoryController@instantSearchSerialnr');
Route::get('inventory/instant-item-serialnr', 	'InventoryController@getInventoryBySerialnr');
Route::get('inventory/{item}/change-brand',     'SupplierController@changeBrand');
Route::post('inventory/db', 					'InventoryController@db');
Route::get('inventory/barcode', 				'InventoryController@barcode');
Route::get('inventory/crop-image', 			    'InventoryController@cropImage');
Route::get('inventory/{item}/generateSku', 		'InventoryController@generateSku');
Route::get('inventory/download', 				'Plugins\CurlController@index');


Route::get('data/categories/children', 	        'CategoryController@children');
