<?php
	require_once 'mysql.php';
	require_once 'constants.php';

	/////////////////////////////
	// getAllList
	// Get the list of everything that is searchable in the database
	///////////////////
	function getAllList(){
		$resultArray = array_merge(getGeneList(), getChemicalList(), getGOList());
		return $resultArray;
	}

	/////////////////////////////
	// GetGeneList
	// Get the list of searchable genes in the database
	/////////////////////////
	function getGeneList(){
		#Connect to the database
		if(!database_connect()){ echo "DB_CONNECT_FAILURE"; return false; }

		$search = "systematic_name, standard_name, gene_name, gene_alias";
		$table = $GLOBALS['TABLE_GENE_NAMES'];

		#Do a database search
		$result = database_select_distinct_search($search, $table);

		# Throw the results into an array
		$resultArray = array();
		while ($row = mysql_fetch_assoc($result)){
			if($row['systematic_name'] != null){ array_push($resultArray, $row['systematic_name']); }
			if($row['standard_name'] != null){ array_push($resultArray, $row['standard_name']); }
			if($row['gene_name'] != null){ array_push($resultArray, $row['gene_name']); }
			if($row['gene_alias'] != null){ array_push($resultArray, $row['gene_alias']); }
		}
		# DC from database
		database_disconnect();

		#return results
		return array_unique($resultArray);
	}
	
	////////////////////////////////
	// Get chemical List
	// Get the list of searchable chemicals
	///////////////////////////////////
	function getChemicalList(){
		#Connect to the database
		if(!database_connect()){ echo "DB_CONNECT_FAILURE"; return false; }

		#Search for name column in table chemicasl
		$search = "chemical_identifier, chemical_name";
		$table = $GLOBALS['TABLE_CHEMICAL_NAMES'];
	
		#Do a database search
		$result = database_select_distinct_search($search, $table);

		# Throw the results into an array
		$resultArray = array();
		while ($row = mysql_fetch_assoc($result)){
			if($row['chemical_identifier'] != null){ array_push($resultArray, $row['chemical_identifier']); }
			if($row['chemical_name'] != null){ array_push($resultArray, $row['chemical_name']); }
		}
		# DC from database
		database_disconnect();

		#return results
		return array_unique($resultArray);
	}

	///////////////////////////////////////
	// getGoList
	// Get the list of searchable go terms
	///////////////////////////////////////
	function getGOList(){
		#Connect to the database
		if(!database_connect()){ echo "DB_CONNECT_FAILURE"; return false; }

		#Search for name column in table chemicasl
		$search = "GO_name, GO_desc";
		$table = $GLOBALS['TABLE_GO_NAMES'];
	
		#Do a database search
		$result = database_select_distinct_search($search, $table);

		# Throw the results into an array
		$resultArray = array();
		while ($row = mysql_fetch_assoc($result)){
			if($row['GO_name'] != null){ array_push($resultArray, $row['GO_name']); }
			if($row['GO_desc'] != null){ array_push($resultArray, $row['GO_desc']); }
		}

		# DC from database
		database_disconnect();

		#return results
		return array_unique($resultArray);
	}

	/*/////////////////////////////////////
	// getGoList_terms
	// Get the list of searchable go terms
	///////////////////////////////////////
	function getGOList_terms(){
		#Connect to the database
		if(!database_connect()){ echo "DB_CONNECT_FAILURE"; return false; }

		#Search for name column in table chemicasl
		$search = "GO_name";
		$table = $GLOBALS['TABLE_GO_NAMES'];
	
		#Do a database search
		$result = database_select_distinct_search($search, $table);

		# Throw the results into an array
		$resultArray = array();
		while ($row = mysql_fetch_assoc($result)){
			if($row['GO_ID'] != null){ array_push($resultArray, $row['GO_ID']); }
		}

		# DC from database
		database_disconnect();

		#return results
		return array_unique($resultArray);
	}

	///////////////////////////////////////
	// getGoList_desc
	// Get the list of searchable go terms
	///////////////////////////////////////
	function getGOList_desc(){
		#Connect to the database
		if(!database_connect()){ echo "DB_CONNECT_FAILURE"; return false; }

		#Search for name column in table chemicasl
		$search = "GO_desc";
		$table = $GLOBALS['TABLE_GO_NAMES'];
	
		#Do a database search
		$result = database_select_distinct_search($search, $table);

		# Throw the results into an array
		$resultArray = array();
		while ($row = mysql_fetch_assoc($result)){
			if($row['go_name'] != null){ array_push($resultArray, $row['GO_description']); }
		}

		# DC from database
		database_disconnect();

		#return results
		return array_unique($resultArray);
	}
	*/

?>
