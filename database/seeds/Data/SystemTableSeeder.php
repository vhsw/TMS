<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\System;

class SystemTableSeeder extends Seeder {

	public function run() {


        DB::table('system')->delete();

        System::create([
        		'variable'=>'request_status',
        		'content'=>'a:4:{i:0;s:4:"REST";i:1;s:9:"REQUESTED";i:2;s:7:"ORDERED";i:3;s:8:"RECIEVED";}']);

        System::create([
        		'variable'=>'barcode_prefix',
        		'content'=>'a:2:{i:0;s:1:"(";i:1;s:1:")";}']);
         
	}
}