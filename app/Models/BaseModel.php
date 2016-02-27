<?php 

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {

	public static function fuzzySearch( $table, $column, $term )
	{
		$escape_term = addslashes($term);
		// whole string
		$rel_100 = $escape_term;

		// beginning of string
		$rel_50 = $escape_term.'%';

		// start and end anywhere
		$rel_30 = '%'.$escape_term.'%';

		// begging of string with any of the characters in the term
		$len = strlen($term);
		$rel_42 = '';
		$rel_32 = '';
		$rel = '';
		for ($i=0; $i<$len; $i++) {
			$char = addslashes(mb_strtoupper($term[$i], 'UTF-8'));
			$rel_42 .= $char . '% ';
			$rel_32 .= $char . '%';
			$rel .= '%' . addslashes($term[$i]);
		} 
		rtrim($rel_42);
		$rel .= '%';

		// every word
		$arr = explode(' ', $escape_term);
		$len = count($arr);
		$rel_35 = '';
		for ($i=0; $i<$len; $i++) {
			$rel_35 .= $arr[$i] . '% ';
		}
		rtrim($rel_35);

		$result = DB::select(DB::raw("SELECT *, 
            IF(`".$column."` = '".$rel_100."', 100, 0) + 
            IF(`".$column."` LIKE '".$rel_50."', 50, 0) + 
            IF(`".$column."` LIKE '".$rel_42."', 42, 0) + 
            IF( REPLACE(`".$column."`, '\.', '') 
                LIKE '".$rel."', 
                ROUND(40 * ( CHAR_LENGTH( '".$escape_term."' ) / CHAR_LENGTH( REPLACE(`".$column."`, ' ', '') ))), 0) + 
            IF(`".$column."` LIKE '".$rel_35."', 35, 0) + 
            IF( CHAR_LENGTH( TRIM( `".$column."` )) = CHAR_LENGTH( REPLACE( TRIM( `".$column."` ), ' ', '')) 
                AND `".$column."` LIKE BINARY '".$rel_35."', 32, 0) + 
            IF(`".$column."` LIKE '".$rel_30."', 30, 0) + 8 * ROUND((CHAR_LENGTH(`".$column."`) - CHAR_LENGTH( REPLACE( LOWER(`".$column."`), lower('".$escape_term."'), ''))) / LENGTH('".$escape_term."')) AS relevance 
            FROM `".$table."` HAVING `relevance` > 0 ORDER BY `relevance` DESC "));

		return $result;
	}
}