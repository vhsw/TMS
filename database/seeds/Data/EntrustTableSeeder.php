<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Role;
use App\Permission;

class EntrustTableSeeder extends Seeder {

	public function run() {

		DB::table('roles')->delete();

		Role::create(['name' => 'admin', 'display_name' => 'Administrator', 'description' => 'User have full access']);
		Role::create(['name' => 'user', 'display_name' => 'User', 'description' => 'User have limited access']);
		Role::create(['name' => 'director', 'display_name' => 'Supervisor', 'description' => 'User have supervisor access']);


		DB::table('role_user')->delete();
		
		DB::table('role_user')->insert(['user_id' => 1, 'role_id' => 1 ]);
		DB::table('role_user')->insert(['user_id' => 2, 'role_id' => 2 ]);

	}
}
