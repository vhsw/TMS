<?php

Route::get('transactions/', 		    'TransactionController@index');


Route::get('transaction/{transaction}/save', 	'TransactionController@save');
Route::get('transaction/request', 	        'TransactionController@request');
Route::get('transaction/{request}/cancel',  'TransactionController@cancel');
Route::get('transaction/{request}/order',   'TransactionController@order');
Route::get('transaction/{request}/receive', 'TransactionController@receive');
Route::get('transaction/{request}/edit', 	'TransactionController@edit');

Route::get('transaction/db', 	            'TransactionController@db');
