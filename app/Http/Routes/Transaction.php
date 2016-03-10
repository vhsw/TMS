<?php

Route::get('transactions/', 		    'TransactionController@index');
Route::get('transaction/request', 	    'TransactionController@request');
Route::post('requests/create', 		    'TransactionController@create');
Route::get('request/{id}/edit', 	    'TransactionController@edit');
Route::post('request/{id}/edit', 	         'TransactionController@save');
Route::get('transaction/{request}/cancel',  'TransactionController@cancel');
Route::get('transaction/{request}/order',   'TransactionController@order');
Route::get('transaction/{request}/receive', 'TransactionController@receive');
Route::get('transaction/db', 	            'TransactionController@db');
