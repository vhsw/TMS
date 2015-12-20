<?php

// CATEGORIES

get('data/categories', 				'CategoryController@index');
post('data/categories/save', 		'CategoryController@save');
get('data/categories/tree', 		'CategoryController@tree'); // AJAX

// LOCATIONS

get('data/locations', 				'LocationController@index');

// SUPPLIERS

get('data/suppliers', 				'SupplierController@index');
get('data/supplier/{id}/view', 		'SupplierController@view');
get('data/supplier/{id}/edit', 		'SupplierController@edit');
post('data/supplier/{id}/edit', 	'SupplierController@save');
post('data/supplier/create', 		'SupplierController@create');

// RESOURCES
get('data/resources', 'ResourceController@index');
post('data/resources/db', 'ResourceController@db'); // AJAX