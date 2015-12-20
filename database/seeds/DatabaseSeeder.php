 <?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserTableSeeder::class);
        $this->call(EntrustTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(ContactsTableSeeder::class);
        $this->call(LocationTableSeeder::class);
        $this->call(ResourceTableSeeder::class);
        $this->call(SystemTableSeeder::class);
        //$this->call(ToolsTableSeeder::class);

        Model::reguard();
    }
}
