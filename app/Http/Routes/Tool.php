<?php

Route::get('tools/search/', 				'ToolController@search');
Route::get('tools/search/result', 			'ToolController@result');
Route::get('tools/browse/', 				'ToolController@browse');
Route::get('tool/{id}/view', 				'ToolController@view');
Route::post('data/tools/db', 				'ToolController@db');	// AJAX
Route::get('tools/typeahead', 				'ToolController@typeahead'); // AJAX
Route::get('tools/barcode', 				'ToolController@barcode'); // AJAX

//post('plugins/download', 					'Plugins\CurlController@index');
Route::get('plugins/download', 				'Plugins\CurlController@index');
Route::get('plugins/download/save', 		'ToolController@savetoolinfo');