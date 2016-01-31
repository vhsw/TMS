<?php namespace App\Services;
/*
 * Script:    DataTables server-side script for PHP and MySQL
 * Copyright: 2012 - John Becker, Beckersoft, Inc.
 * Copyright: 2010 - Allan Jardine
 * License:   GPL v2 or BSD (3-point)
 */
  
class AjaxTable {
 
 	private $_db;
 	private $_request;
 	private $_table;
 	private $_columns = array();
 	private $_search = array();
 	private $_with = "";

	public function __construct($request) {
		$this->_request = $request;
		try {
			$host		= \Config::get('database.connections.mysql.host');
			$database	= \Config::get('database.connections.mysql.database');
			$user		= \Config::get('database.connections.mysql.username');
			$passwd		= \Config::get('database.connections.mysql.password');
		
		    $this->_db = \DB::connection()->getPdo();
		} catch (PDOException $e) {
		    error_log("Failed to connect to database: ".$e->getMessage());
		}		
		
	}


	public function select($table, $columns) {
		$this->_table = $table;
		foreach($columns as $column)
		{
			array_push($this->_columns, $table.".".$column);
			array_push($this->_search, "`".$table."`.`".$column."`");
		}
	}


	public function with($table, $columns, $alias, $foreign_key) {
		foreach($columns as $column)
		{
			array_push($this->_columns, $table.".".$column);
			array_push($this->_search, "`".$table."`.`".$column."`");
		}
		$this->_with .= "LEFT JOIN `".$table."` ON `".$this->_table."`.`".$foreign_key."` = `".$table."`.`id` ";
	}


	public function get() {
		//
		// Paging
		//-------------------------------------
		$sLimit = "";

		if ( $this->_request->has('start') && $this->_request->input('length') != '-1' ) {
			$sLimit = "LIMIT ".intval( $this->_request->input('start') ).", ".intval( $this->_request->input('length') );
		}
		
		//
		// Ordering
		//-------------------------------------
		$sOrder = "";

		if ( $this->_request->input('order')[0]['column'] != '' ) {
			$o = intval( $this->_request->input('order')[0]['column'] );
			$sOrder = "ORDER BY  ";
			if ( $this->_request->input('columns')[$o]['orderable'] == "true" ) {
				$sortDir = (strcasecmp($this->_request->input('order')[0]['dir'], 'ASC') == 0) ? 'ASC' : 'DESC';
				$sOrder .= "`".$this->_columns[ $o ]."` ". $sortDir .", ";
			}
			
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY" ) {
				$sOrder = "";
			}
		}
		
		/* 
		 * Filtering
		 * NOTE this does not match the built-in DataTables filtering which does it
		 * word by word on any field. It's possible to do here, but concerned about efficiency
		 * on very large tables, and MySQL's regex functionality is very limited
		 */
		$sWhere = "";
		if ( $this->_request->has('search') && $this->_request->input('search')['value'] != "" ) {
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($this->_search) ; $i++ ) {
				if ( $this->_request->input('columns')[$i]['searchable'] == "true" ) {
					$sWhere .= $this->_search[$i]." LIKE '%".$this->_request->input('search')['value']."%' OR ";
				}
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		// Individual column filtering
		for ( $i=0 ; $i<count($this->_search) ; $i++ ) {
			if ( $this->_request->input('columns')[$i]['searchable'] == "true" && $this->_request->input('columns')[$i]['search']['value'] != '' ) {
				if ( $sWhere == "" ) {
					$sWhere = "WHERE ";
				}
				else {
					$sWhere .= " AND ";
				}
				$sWhere .= $this->_search[$i]." LIKE '".$this->_request->input('columns')[$i]['search']['value']."' ";
			}
		}



		$sql = "";
		foreach($this->_columns AS $column){
			$str = explode(".", $column);
			$sql = $sql."`".$str[0]."`.`".$str[1]."` AS '".$column."', ";
		}
		$sql = substr_replace($sql, "", -2 );

		


		$sQuery = "	SELECT SQL_CALC_FOUND_ROWS ".$sql." 
					FROM `".$this->_table."` 
					".$this->_with." 
					".$sWhere." 
					".$sOrder." 
					".$sLimit;

		$statement = $this->_db->prepare($sQuery);
		$statement->execute();
		$rResult = $statement->fetchAll();
		
	    $iFilteredTotal = current($this->_db->query('SELECT FOUND_ROWS()')->fetch());
		
		// Get total number of rows in table
		$sQuery = "SELECT COUNT(`id`) FROM `".$this->_table."`";
		$iTotal = current($this->_db->query($sQuery)->fetch());
		
		

		// Output
		$output = array(
			"draw" => intval($this->_request->input('draw')),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		

		// Return array of values 
		foreach($rResult as $aRow) {
			$row = array();			
			for ( $i = 0; $i < count($this->_columns); $i++ ) {
				if ( $this->_columns[$i] != ' ' ) {
					$row[] = $aRow[ $this->_columns[$i] ];
				}
			}
			$output['aaData'][] = $row;
		} 

		return $output;
	} 
}

?>