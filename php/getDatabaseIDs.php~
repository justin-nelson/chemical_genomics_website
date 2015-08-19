<?php
	require_once 'mysql.php';
	require_once 'constants.php';

	////////////////////////
	//	Get Gene ID's
	////////////
	function getGeneDatabaseIDs($genes){
		#Connect to the database
		if(!database_connect()){ echo "DB_CONNECT_FAILURE"; return false; }
		if(empty($genes)){ return array(); }

		$search = "pid";
		$table = $GLOBALS['TABLE_GENE_NAMES'];

		#Build the where statement
		$orQueryArray = array();
		if(!empty($genes)){ array_push($orQueryArray, "systematic_name IN ".build_IN_LIST($genes));}
		if(!empty($genes)){ array_push($orQueryArray, "standard_name IN ".build_IN_LIST($genes));}
		if(!empty($genes)){ array_push($orQueryArray, "gene_name IN ".build_IN_LIST($genes));}
		if(!empty($genes)){ array_push($orQueryArray, "gene_alias IN ".build_IN_LIST($genes));}

		$where = build_OR($orQueryArray);

		#Do the search
		$result = database_select_distinct_search($search, $table, $where);

		# Throw the results into an array
		$resultArray = array();
		while ($row = mysql_fetch_assoc($result)){
			array_push($resultArray, $row["pid"]);
		}

		#database dc
		database_disconnect();

		#return the results array
		#if(count($resultArray) == 0){return "EMPTY";}	# Is the array empty?	
		return $resultArray;
	}

	////////////////////////
	//	Get Chemical ID's
	////////////
	function getChemicalDatabaseIDs($chemicals){
		#Connect to the database
		if(!database_connect()){ echo "DB_CONNECT_FAILURE"; return false; }
		if(empty($chemicals)){ return array(); }

		$search = "pid";
		$table = $GLOBALS['TABLE_CHEMICAL_NAMES'];

		#Build the where statement
		$orQueryArray = array();
		if(!empty($chemicals)){ array_push($orQueryArray, "chemical_identifier IN ".build_IN_LIST($chemicals));}
		if(!empty($chemicals)){ array_push($orQueryArray, "chemical_name IN ".build_IN_LIST($chemicals));}

		$where = build_OR($orQueryArray);

		#Do the search
		$result = database_select_distinct_search($search, $table, $where);

		# Throw the results into an array
		$resultArray = array();
		while ($row = mysql_fetch_assoc($result)){
			array_push($resultArray, $row["pid"]);
		}

		#database dc
		database_disconnect();

		#return the results array
		#if(count($resultArray) == 0){return "EMPTY";}	# Is the array empty?	
		return $resultArray;
	}

	////////////////////////
	//	Get GO ID's
	////////////
	function getGeneOntologyDatabaseIDs($terms){
		#Connect to the database
		if(!database_connect()){ echo "DB_CONNECT_FAILURE"; return false; }
		if(empty($terms)){ return array(); }

		$search = "pid";
		$table = $GLOBALS['TABLE_GO_NAMES'];

		#Build the where statement
		$orQueryArray = array();
		if(!empty($terms)){ array_push($orQueryArray, "GO_name IN ".build_IN_LIST($terms));}
		if(!empty($terms)){ array_push($orQueryArray, "GO_desc IN ".build_IN_LIST($terms));}

		$where = build_OR($orQueryArray);

		#Do the search
		$result = database_select_distinct_search($search, $table, $where);

		# Throw the results into an array
		$resultArray = array();
		while ($row = mysql_fetch_assoc($result)){
			array_push($resultArray, $row["pid"]);
		}

		#database dc
		database_disconnect();

		#return the results array
		#if(count($resultArray) == 0){return "EMPTY";}	# Is the array empty?	
		return $resultArray;
	}
?>
