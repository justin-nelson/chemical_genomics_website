<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	require_once 'mysql.php';
	require_once 'constants.php';

	###################################################
	# Search_{table name}
	# Searches the {table name} for the results
	function search_info_chemicals($chemicals){ // This search has the purpose of grabbing chemical info
		if(!database_connect()){ return "DB_CONNECT_FAILURE"; }
		if(empty($chemicals)){ return array(); }

		# Set up parameters
		$search = "*";
		$table = $GLOBALS['TABLE_CHEMICAL_NAMES'];

		#Build the where statement
		$andQueryArray = array();

		if(!empty($chemicals)){ array_push($andQueryArray, $GLOBALS['TABLE_CHEMICAL_NAMES'].".pid IN ".build_IN_LIST($chemicals));}
		$where = build_AND($andQueryArray);

		#Do the search
		$result = database_select_distinct_search($search, $table, $where);

		# Throw the results into an array
		$resultArray = array();
		while ($row = mysql_fetch_assoc($result)){
			#$row["pid"] = $row["chemid"];
			$row["searchType"] = "CHEMICAL";
			array_push($resultArray, $row);
		}

		#database dc
		database_disconnect();

		#return the results array
		if(count($resultArray) == 0){return "EMPTY";}	# Is the array empty?	
		return $resultArray;
	}

	# This will grab the information about Genes
	function search_info_genes($genes){ 
		if(!database_connect()){ return "DB_CONNECT_FAILURE"; }
		if(empty($genes)){ return array(); }

		# Set up parameters
		$search = "*";
		$table = $GLOBALS['TABLE_GENE_NAMES'];

			
		#Build the where statement
		$where = "0 = 1";
		if(!empty($genes)){ $where = "pid IN ".build_IN_LIST($genes); }

		#Do the search
		$result = database_select_distinct_search($search, $table, $where);

		# Throw the results into an array
		$resultArray = array();
		while ($row = mysql_fetch_assoc($result)){
			$row["searchType"] = "GENE";
			array_push($resultArray, $row);
		}

		#database dc
		database_disconnect();

		#return the results array
		if(count($resultArray) == 0){return "EMPTY";}	# Is the array empty?	
		return $resultArray;
	}

	# This will grab the information about GO terms
	function search_info_GO_terms($GO_terms){ 
		if(!database_connect()){ return "DB_CONNECT_FAILURE"; }
		if(empty($GO_terms)){ return array(); }

		# Set up parameters
		$search = "*";
		$table = $GLOBALS['TABLE_GO_NAMES'];

		#Build the where statement
		$where = "0 = 1";
		if(!empty($GO_terms)){ $where = "pid IN ".build_IN_LIST($GO_terms);}

		#Do the search
		$result = database_select_distinct_search($search, $table, $where);

		# Throw the results into an array
		$resultArray = array();
		while ($row = mysql_fetch_assoc($result)){
			$row["searchType"] = "GO";
			array_push($resultArray, $row);
		}

		#database dc
		database_disconnect();

		#return the results array
		if(count($resultArray) == 0){return "EMPTY";}	# Is the array empty?	
		return $resultArray;
	}

?>
