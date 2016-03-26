<?php

// CATEGORIES
Route::get('data/categories', 				        'CategoryController@index');
Route::post('data/categories/save', 		        'CategoryController@save');
Route::get('categories/get-immediate-descendants', 	'CategoryController@getImmediateDescendants'); // AJAX
Route::get('categories/generate-select-boxes', 	    'CategoryController@generateSelectBoxes'); // AJAX

// LOCATIONS
Route::get('data/locations', 		                 'LocationController@index');

// SUPPLIERS
Route::get('suppliers/get-possible-suppliers', 		 'SupplierController@getPossibleSuppliers'); // AJAX

Route::get('data/suppliers', 				       'SupplierController@index');
Route::get('data/supplier/{id}/view', 		        'SupplierController@view');
Route::get('data/supplier/{id}/edit', 		        'SupplierController@edit');
Route::post('data/supplier/{id}/edit', 	            'SupplierController@save');
Route::post('data/supplier/create', 		      'SupplierController@create');

// RESOURCES
Route::get('data/resources',                    'ResourceController@index');
Route::post('data/resources/db',                   'ResourceController@db'); // AJAX
