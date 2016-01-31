<?php

// VARIABLES

get('system/variables', 						'SystemController@systemvariables');
post('system/variable/{variable}/save', 		'SystemController@save');
