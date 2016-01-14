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


		DB::table('users_roles')->delete();
		
		DB::table('users_roles')->insert(['user_id' => 1, 'role_id' => 1 ]);
		DB::table('users_roles')->insert(['user_id' => 2, 'role_id' => 2 ]);

	}
}
