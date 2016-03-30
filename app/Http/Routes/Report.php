<?php

// Total Inventory
Route::get('report/total-inventory',                    'InventoryController@getTotalInventory');
Route::get('statistic/total-inventory-per-supplier',    'StatisticController@chartTotalInventoryPerSupplier');
