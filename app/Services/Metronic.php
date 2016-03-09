<?php namespace App\Services;


class Metronic {

	public static function classStatus($val)
	{
		$class = "";
		switch($val){
			case 'REST': $class = "label-warning"; break;
			case 'REQUESTED': $class = "label-danger"; break;
			case 'ORDERED': $class = "label-info"; break;
			case 'RECIEVED': $class = "label-success"; break;
		}

		return $class;
	}

	public static function renderNode($node) {
		echo "<li>";
		echo "<b>{$node->name}</b>";

		if ( $node->children() ) {
			echo "<ul>";
			foreach($node->children as $child) Metronic::renderNode($child);
			echo "</ul>";
		}

		echo "</li>";
	}
}
