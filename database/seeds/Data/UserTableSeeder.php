<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;

class UserTableSeeder extends Seeder {

	public function run() {

		DB::table('users')->delete();

		User::create(['name' => 'John Wennstrøm', 'username' => '125', 'resource_id' => 1, 'email' => '125@125.com', 'password' => bcrypt('125')]);
		User::create(['name' => 'User', 'username' => '124', 'resource_id' => 2, 'email' => 'user@user.com', 'password' => bcrypt('124')]);

	}
}
