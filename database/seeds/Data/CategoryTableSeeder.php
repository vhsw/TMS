<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategoryTableSeeder extends Seeder {

	public function run() {

        DB::table('categories')->delete();

        Category::create(['name'=>'Vendeskjær',		'parent_id'=>'0', 'sort'=>'1',				'icon'=>'E001']);
	        Category::create(['name'=>'Dreieskjær',		'parent_id'=>'1', 'sort'=>'2',				'icon'=>'E007']);
	        Category::create(['name'=>'Freseskjær',		'parent_id'=>'1', 'sort'=>'3',				'icon'=>'E005']);
	        Category::create(['name'=>'Gjengeskjær',	'parent_id'=>'1', 'sort'=>'4',				'icon'=>'E012']);
	        	Category::create(['name'=>'Acme 29°',		'parent_id'=>'4', 'sort'=>'5',				'icon'=>'']);
	        	Category::create(['name'=>'Stub Acme 29°',	'parent_id'=>'4', 'sort'=>'6',				'icon'=>'']);
	        	Category::create(['name'=>'Metric 60°',		'parent_id'=>'4', 'sort'=>'7',				'icon'=>'']);
	        	Category::create(['name'=>'UN 60°',			'parent_id'=>'4', 'sort'=>'8',				'icon'=>'']);
	        	Category::create(['name'=>'Withworth 55°',	'parent_id'=>'4', 'sort'=>'9',				'icon'=>'']);
	        	Category::create(['name'=>'NPT 60°',		'parent_id'=>'4', 'sort'=>'10',				'icon'=>'']);
	        	Category::create(['name'=>'BSP 55°',		'parent_id'=>'4', 'sort'=>'11',				'icon'=>'']);
	        	Category::create(['name'=>'TR 30°',			'parent_id'=>'4', 'sort'=>'12',				'icon'=>'']);
	        Category::create(['name'=>'Borskjær',		'parent_id'=>'1', 'sort'=>'13',				'icon'=>'E004']);
	        Category::create(['name'=>'Sporskjær',		'parent_id'=>'1', 'sort'=>'14',				'icon'=>'E002']);
	        Category::create(['name'=>'Gjengefresskjær','parent_id'=>'1', 'sort'=>'15',				'icon'=>'G034']);

        Category::create(['name'=>'Freseverktøy',	'parent_id'=>'0', 'sort'=>'16',				'icon'=>'G012']);
        	Category::create(['name'=>'Gjengefreser',	'parent_id'=>'16', 'sort'=>'17',				'icon'=>'']);
        	Category::create(['name'=>'Hardmetall',		'parent_id'=>'16', 'sort'=>'18',				'icon'=>'']);
        	Category::create(['name'=>'HSS',			'parent_id'=>'16', 'sort'=>'19',				'icon'=>'']);
        	Category::create(['name'=>'Radiefreser',	'parent_id'=>'16', 'sort'=>'20',				'icon'=>'']);
        	Category::create(['name'=>'Specialfreser',	'parent_id'=>'16', 'sort'=>'21',				'icon'=>'']);

        Category::create(['name'=>'Bor',			'parent_id'=>'0', 'sort'=>'22',				'icon'=>'B004']);
        	Category::create(['name'=>'Hardmetall',		'parent_id'=>'22', 'sort'=>'23',				'icon'=>'']);
        	Category::create(['name'=>'HSS',			'parent_id'=>'22', 'sort'=>'24',				'icon'=>'']);
        	Category::create(['name'=>'PFX',			'parent_id'=>'22', 'sort'=>'25',				'icon'=>'']);
        	Category::create(['name'=>'Lange',			'parent_id'=>'22', 'sort'=>'26',				'icon'=>'']);

        Category::create(['name'=>'Brotsjer',		'parent_id'=>'0', 'sort'=>'27',				'icon'=>'D038']);

        Category::create(['name'=>'Gjengetapper',	'parent_id'=>'0', 'sort'=>'28',				'icon'=>'D035']);
        	Category::create(['name'=>'Metric',			'parent_id'=>'28', 'sort'=>'29',				'icon'=>'']);
        	Category::create(['name'=>'NPT',			'parent_id'=>'28', 'sort'=>'30',				'icon'=>'']);
        	Category::create(['name'=>'UNC',			'parent_id'=>'28', 'sort'=>'31',				'icon'=>'']);
        	Category::create(['name'=>'UNF',			'parent_id'=>'28', 'sort'=>'32',				'icon'=>'']);
        	Category::create(['name'=>'G (Withworth)',	'parent_id'=>'28', 'sort'=>'33',				'icon'=>'']);

	}
}
