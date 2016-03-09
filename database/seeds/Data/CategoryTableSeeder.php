<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategoryTableSeeder extends Seeder {

	public function run() {

        DB::table('categories')->delete();

		$root = Category::create([										'name' => 'All Products']);
			$skjaerende = $root->children()->create([					'name' => 'Skjærende Verktøy']);
				$vendeskjaer = $skjaerende->children()->create([		'name' => 'Vendeskjær', 			'icon'=>'E001']);
					$vendeskjaer->children()->create([					'name' => 'Dreieskjær', 			'icon'=>'E007']);
					$vendeskjaer->children()->create([					'name' => 'Freseskjær', 			'icon'=>'E005']);
					$gjengeskjaer = $vendeskjaer->children()->create([	'name' => 'Gjengeskjær', 			'icon'=>'E012']);
						$gjengeskjaer->children()->create([				'name' => 'Acme 29°']);
						$gjengeskjaer->children()->create([				'name' => 'Stub Acme 29°']);
						$gjengeskjaer->children()->create([				'name' => 'Metric 60°']);
						$gjengeskjaer->children()->create([				'name' => 'UN 60°']);
						$gjengeskjaer->children()->create([				'name' => 'Withworth 55°']);
						$gjengeskjaer->children()->create([				'name' => 'NPT 60°']);
						$gjengeskjaer->children()->create([				'name' => 'BSP 55°']);
						$gjengeskjaer->children()->create([				'name' => 'TR 30°']);
					$vendeskjaer->children()->create([					'name' => 'Borskjær', 				'icon'=>'E004']);
					$vendeskjaer->children()->create([					'name' => 'Sporskjær', 				'icon'=>'E002']);
					$vendeskjaer->children()->create([					'name' => 'Gjengefresskjær', 		'icon'=>'G034']);
				$freseverktoy = $skjaerende->children()->create([		'name'=>'Freseverktøy', 			'icon'=>'G012']);
					$freseverktoy->children()->create([					'name' => 'Gjengefreser']);
					$freseverktoy->children()->create([					'name' => 'Hardmetall']);
					$freseverktoy->children()->create([					'name' => 'HSS']);
					$freseverktoy->children()->create([					'name' => 'Radiefreser']);
					$freseverktoy->children()->create([					'name' => 'Specialfreser']);
				$bor = $skjaerende->children()->create([				'name'=>'Bor', 						'icon'=>'B004']);
					$bor->children()->create([							'name' => 'Hardmetall']);
					$bor->children()->create([							'name' => 'HSS']);
					$bor->children()->create([							'name' => 'PFX']);
					$bor->children()->create([							'name' => 'Lange']);
				$brotsjer = $skjaerende->children()->create([			'name'=>'Brotsjer', 				'icon'=>'D038']);
				$gjengetapper = $skjaerende->children()->create([		'name'=>'Gjengetapper', 			'icon'=>'D035']);
					$gjengetapper->children()->create([					'name' => 'Metric']);
					$gjengetapper->children()->create([					'name' => 'NPT']);
					$gjengetapper->children()->create([					'name' => 'UNC']);
					$gjengetapper->children()->create([					'name' => 'UNF']);
					$gjengetapper->children()->create([					'name' => 'G (Withworth)']);

	}
}
