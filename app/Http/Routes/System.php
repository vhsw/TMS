<?php

// VARIABLES

Route::get('system/variables', 				'SystemController@systemvariables');
Route::post('system/variables/save', 		'SystemController@save');
Route::get('system/update', 				'SystemController@update');
