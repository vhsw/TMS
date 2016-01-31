<?php

// VARIABLES

Route::get('system/variables', 						'SystemController@systemvariables');
Route::post('system/variable/{variable}/save', 		'SystemController@save');
