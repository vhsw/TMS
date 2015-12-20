<?php

get('tools/search/', 				'ToolController@search');
get('tools/search/result', 			'ToolController@result');
get('tools/browse/', 				'ToolController@browse');
get('tool/{id}/view', 				'ToolController@view');
post('admin/data/tools/db', 		'ToolController@db');	// AJAX
get('tools/typeahead', 				'ToolController@typeahead'); // AJAX
get('tools/barcode', 				'ToolController@barcode'); // AJAX

get('tools/requests', 				'RequestController@index');
get('tools/request', 				'RequestController@request');
post('tools/requests/create', 		'RequestController@create');
get('tools/request/{id}/edit', 		'RequestController@edit');
post('tools/request/{id}/edit', 	'RequestController@save');
get('tools/request/{id}/delete', 	'RequestController@delete');
post('admin/data/requests/db', 		'RequestController@db'); // AJAX



Route::group(['middleware' => 'auth'], function () 
{
	get('tool/{id}/edit', 			'ToolController@edit');
	get('tool/{id}/save', 			'ToolController@save');

});