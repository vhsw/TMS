<?php namespace App\Services;
/*
 * Script:    DataTables server-side script for PHP and MySQL
 * Copyright: 2012 - John Becker, Beckersoft, Inc.
 * Copyright: 2010 - Allan Jardine
 * License:   GPL v2 or BSD (3-point)
 */
  
class TableData {
 
 	private $_db;
 	private $_request;

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
	public function get($table, $index_column, $columns) {
		// Paging
		$sLimit = "";
		if ( $this->_request->has('start') && $this->_request->input('length') != '-1' ) {
			$sLimit = "LIMIT ".intval( $this->_request->input('start') ).", ".intval( $this->_request->input('length') );
		}
		
		// Ordering
		$sOrder = "";
		if ( $this->_request->input('order')[0]['column'] != '' ) {
			$o = intval( $this->_request->input('order')[0]['column'] );
			$sOrder = "ORDER BY  ";
			if ( $this->_request->input('columns')[$o]['orderable'] == "true" ) {
				$sortDir = (strcasecmp($this->_request->input('order')[0]['dir'], 'ASC') == 0) ? 'ASC' : 'DESC';
				$sOrder .= "`".$columns[ $o ]."` ". $sortDir .", ";
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
			for ( $i=0 ; $i<count($columns) ; $i++ ) {
				if ( $this->_request->input('columns')[$i]['searchable'] == "true" ) {
					$sWhere .= "`".$columns[$i]."` LIKE '%".$this->_request->input('search')['value']."%' OR ";
				}
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		
		// Individual column filtering
		for ( $i=0 ; $i<count($columns) ; $i++ ) {
			if ( $this->_request->input('columns')[$i]['searchable'] == "true" && $this->_request->input('columns')[$i]['search']['value'] != '' ) {
				if ( $sWhere == "" ) {
					$sWhere = "WHERE ";
				}
				else {
					$sWhere .= " AND ";
				}
				$sWhere .= "`".$columns[$i]."` LIKE '%".$this->_request->input('search')['value']."%' ";
			}
		}
		
		// SQL queries get data to display
		$sQuery = "SELECT SQL_CALC_FOUND_ROWS `".str_replace(" , ", " ", implode("`, `", $columns))."` FROM `".$table."` ".$sWhere." ".$sOrder." ".$sLimit;
		$statement = $this->_db->prepare($sQuery);
		



		$statement->execute();
		$rResult = $statement->fetchAll();
		
		$iFilteredTotal = current($this->_db->query('SELECT FOUND_ROWS()')->fetch());
		
		// Get total number of rows in table
		$sQuery = "SELECT COUNT(`".$index_column."`) FROM `".$table."`";
		$iTotal = current($this->_db->query($sQuery)->fetch());
		
		if($this->_request->has('sEcho')) {
			$sEcho = $this->_request->input('sEcho');
		} else {
			$sEcho = 0;
		}
	
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
			for ( $i = 0; $i < count($columns); $i++ ) {
				if ( $columns[$i] == "version" ) {
					// Special output formatting for 'version' column
					$row[] = ($aRow[ $columns[$i] ]=="0") ? '-' : $aRow[ $columns[$i] ];
				}
				else if ( $columns[$i] != ' ' ) {
					$row[] = $aRow[ $columns[$i] ];
				}
			}
			$output['aaData'][] = $row;
		}
		
		return json_encode($output);
	}
}
//header('Pragma: no-cache');
//header('Cache-Control: no-store, no-cache, must-revalidate');
// Create instance of TableData class

//$table_data = new TableData();
// Get the data
//$table_data->get('resources', 'id', array('name', 'short_name', 'controller'));
/*
 * Alternatively, you may want to use the same class for several differnt tables for different pages.
 * By adding something similar to the following to your .htaccess file you can control this a little more...
 *
 * RewriteRule ^pagename/data/?$ data.php?_page=PAGENAME [L,NC,QSA]
 *
 
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_REQUEST['_page'])) {
        	if($_REQUEST['_page'] === 'PAGENAME') {
	            $table_data->get('table_name', 'index_column', array('column1', 'column2', 'columnN'));
	        }
        }
        break;
    default:
        header('HTTP/1.1 400 Bad Request');
}
*/
?>