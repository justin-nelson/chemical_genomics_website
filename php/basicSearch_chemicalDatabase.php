<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	require_once 'mysql.php';

	////////////////////////
	// Search_{table name}
	// Searches the {table name} for the results
	function search_chemicalALL($chemicals){
		if(!database_connect()){ return "DB_CONNECT_FAILURE"; }
		if(empty($chemicals)){ return "NO_SEARCH"; }

		# Set up parameters
		$search = "pid, structure_pic, name as chemical_name";
		$table = "chemicals";

		#Build the where statement
		$andQueryArray = array();

		if(!empty($chemicals)){ array_push($andQueryArray, "name IN ".build_IN_LIST($chemicals));}
		$where = build_AND($andQueryArray);

		#Do the search
		$result = database_select_distinct_search($search, $table, $where);

		# Throw the results into an array
		$resultArray = array();
		while ($row = mysql_fetch_assoc($result)){
			$row["chemical_multiplex"] = "ALL";
			$row["replicate"] = "ALL";
			$row["lane"] = "ALL";
			array_push($resultArray, $row);
		}

		#database dc
		database_disconnect();

		#return the results array
		if(count($resultArray) == 0){return "EMPTY";}	# Is the array empty?	
		return $resultArray;
	}

	function search_infoTable($chemicals){
		if(!database_connect()){ return "DB_CONNECT_FAILURE"; }
		if(empty($chemicals)){ return "NO_SEARCH"; }

		# Set up parameters of a basic chemicalSGA search
		$search = "chemicalConditions.*, chemicals.structure_pic";
		$table = "chemicalConditions, chemicals";


		#Build the where statement
		$andQueryArray = array();

		if(!empty($chemicals)){ array_push($andQueryArray, "chemicalConditions.chemical_name IN ".build_IN_LIST($chemicals));}
		//array_push($andQueryArray, build_OR($chemicals, "chemicalConditions.chemical_name='", "'"));}
		array_push($andQueryArray, 'chemicalConditions.chemical_name = chemicals.name');
		$where = build_AND($andQueryArray);
//echo($where);
//print $where;
		#Do the search
		$result = database_select_distinct_search($search, $table, $where);

		# Throw the results into an array
		$resultArray = array();
		while ($row = mysql_fetch_assoc($result)){
			array_push($resultArray, $row);
		}

		#database dc
		database_disconnect();

		#return the results array
		if(count($resultArray) == 0){return "EMPTY";}	# Is the array empty?	
		return $resultArray;
	}
	/*
	function search_profileSimilarity($chemicals){
		if(!database_connect()){ return "DB_CONNECT_FAILURE"; }
		if(empty($chemicals)){ return "NO_SEARCH"; }

		# Set up parameters of a basic chemicalSGA search
		$search = "*";
		$table = "profileSimilarity";

		#Build the where statement
		$andQueryArray = array();

		if(!empty($chemicals)){ array_push($andQueryArray, build_OR($chemicals, "chemical1_name='", "'"));}
		$where = build_AND($andQueryArray);

		#Do the search
		$result = database_select_search($search, $table, $where);

		# Throw the results into an array
		$resultArray = array();
		while ($row = mysql_fetch_assoc($result)){		
			array_push($resultArray, $row);
		}

		#database dc
		database_disconnect();

		#return the results array
		if(count($resultArray) == 0){return "EMPTY";}	# Is the array empty?	
		return $resultArray;
	}
	function search_chemicalSimilarity($chemicals){
		if(!database_connect()){ return "DB_CONNECT_FAILURE"; }
		if(empty($chemicals)){ return "NO_SEARCH"; }

		# Set up parameters of a basic chemicalSGA search
		$search = "*";
		$table = "chemicalSimilarity";

		#Build the where statement
		$andQueryArray = array();

		if(!empty($chemicals)){ array_push($andQueryArray, build_OR($chemicals, "chemical1_name='", "'"));}
		$where = build_AND($andQueryArray);

		#Do the search
		$result = database_select_search($search, $table, $where);

		# Throw the results into an array
		$resultArray = array();
		while ($row = mysql_fetch_assoc($result)){		
			array_push($resultArray, $row);
		}

		#database dc
		database_disconnect();

		#return the results array
		if(count($resultArray) == 0){return "EMPTY";}	# Is the array empty?	
		return $resultArray;
	}

	function search_chemicalInfo($chemicals){
		if(!database_connect()){ return "DB_CONNECT_FAILURE"; }
		if(empty($chemicals)){ return "NO_SEARCH"; }

		# Set up parameters of a basic chemicalSGA search
		$search = "*";
		$table = "chemicals";

		#Build the where statement
		$andQueryArray = array();

		if(!empty($chemicals)){ array_push($andQueryArray, build_OR($chemicals, "name='", "'"));}
		$where = build_AND($andQueryArray);

		#Do the search
		$result = database_select_distinct_search($search, $table, $where);

		# Throw the results into an array
		$resultArray = array();
		while ($row = mysql_fetch_assoc($result)){		
			array_push($resultArray, $row);
		}

		#database dc
		database_disconnect();

		#return the results array
		if(count($resultArray) == 0){return "EMPTY";}	# Is the array empty?	
		return $resultArray;
	}

	
	function search_chemicalSGA($genes, $chemicals){
		if(!database_connect()){ return "DB_CONNECT_FAILURE"; }
		if(empty($genes) and empty($chemicals)){ return "NO_SEARCH"; }
		
		# Set up parameters of a basic chemicalSGA search
		$search = "chemical_name, chemical_multiplex, replicate, lane, gene_common_name, p_value";
		$table = "chemicalSGA";
		$sortedBy = "correlation";
		
		#Build the where statement
		$andQueryArray = array();
		
		if(!empty($genes)){ array_push($andQueryArray, build_OR($genes, "gene_common_name='", "'"));}
		if(!empty($chemicals)){ array_push($andQueryArray, build_OR($chemicals, "chemical_name='", "'"));}
		
		$where = build_AND($andQueryArray);
		
		#Do the search
		$result = database_select_search($search, $table, $where, $sortedBy);

		# Throw the results into an array
		$resultArray = array();
		while ($row = mysql_fetch_assoc($result)){		
			array_push($resultArray, $row);
		}

		#database dc
		database_disconnect();

		#return the results array
		if(count($resultArray) == 0){return "EMPTY";}	# Is the array empty?	
		return $resultArray;
	}

	function search_chemicalGO($chemicals, $GOterms){
		if(!database_connect()){ return "DB_CONNECT_FAILURE"; }
		if(empty($GOterms) and empty($chemicals)){ return "NO_SEARCH"; }
		
		# Set up parameters of a basic chemicalSGA search
		//$search = "*";
		$search = "chemical_name, chemical_multiplex, replicate, lane, GO_ID, GO_description, ratio_in_study, ratio_in_pop, p_bonferroni";
		$table = "chemicalGO";
		$sortedBy = "p_bonferroni";
		
		#Build the where statement
		$andQueryArray = array();
		
		if(!empty($GOterms)){ array_push($andQueryArray, build_OR($GOterms, "gene_common_name='", "'"));}
		if(!empty($chemicals)){ array_push($andQueryArray, build_OR($chemicals, "chemical_name='", "'"));}
		
		$where = build_AND($andQueryArray);
		
		#Do the search
		$result = database_select_search($search, $table, $where, $sortedBy);

		# Throw the results into an array
		$resultArray = array();
		while ($row = mysql_fetch_assoc($result)){
			array_push($resultArray, $row);
		}

		#database dc
		database_disconnect();

		#return the results array
		if(count($resultArray) == 0){return "EMPTY";}	# Is the array empty?	
		return $resultArray;
	}

	function search_chemicalGenetics($genes, $chemicals){
		if(!database_connect()){ return "DB_CONNECT_FAILURE"; }
		if(empty($genes) && empty($chemicals)){ return "NO_SEARCH"; }
		
		# Set up parameters of a basic chemicalGEN search
		//$search = "*";
		$search = "chemical_name, chemical_multiplex, replicate, lane, gene_common_name, score";
		$table = "chemicalgenetics";
		$sortedBy = "score";
		
		#Build the where statement
		$andQueryArray = array();
		
		if(!empty($genes)){ array_push($andQueryArray, build_OR($genes, "gene_common_name='", "'"));}
		if(!empty($chemicals)){ array_push($andQueryArray, build_OR($chemicals, "chemical_name='", "'"));}

		$where = build_AND($andQueryArray);
		
		#Do the search
		$result = database_select_search($search, $table, $where, $sortedBy);

		# Throw the results into an array
		$resultArray = array();
	
			
		while ($row = mysql_fetch_assoc($result)){
			array_push($resultArray, $row);
		}

		#database dc
		database_disconnect();

		#return the results array
		if(count($resultArray) == 0){return "EMPTY";}	# Is the array empty?	
		return $resultArray;
	}

	function search_parsons($chemicals){
		if(!database_connect()){ return "DB_CONNECT_FAILURE"; }
		if(empty($chemicals)){ return "NO_SEARCH"; }
		
		# Set up parameters of a basic parsons search
		$search = "*";
		$table = "parsons";
		$sortedBy = "p_value";
		
		#Build the where statement
		$andQueryArray = array();
		$orQueryArray = array();
		
		if(!empty($chemicals)){ array_push($orQueryArray, build_OR($chemicals, "chemical1_name='", "'"));}
		if(!empty($chemicals)){ array_push($orQueryArray, build_OR($chemicals, "chemical2_name='", "'"));}
		array_push($andQueryArray, build_OR($orQueryArray));

		$where = build_AND($andQueryArray);

		#Do the search
		$result = database_select_search($search, $table, $where, $sortedBy);

		# Throw the results into an array
		$resultArray = array();
		while ($row = mysql_fetch_assoc($result)){
			array_push($resultArray, $row);
		}

		#database dc
		database_disconnect();

		#return the results array
		if(count($resultArray) == 0){return "EMPTY";}	# Is the array empty?	
		return $resultArray;
	}

	function search_chemicalComplex($chemicals, $minGenes = 0){
		if(!database_connect()){ return "DB_CONNECT_FAILURE"; }
		if(empty($genes) && empty($chemicals)){ return "NO_SEARCH"; }

		# Set up parameters of a basic chemicalCOMPLEX search
		$search = "*";
		$table = "chemicalComplex";
		$sortedBy = "z_score";
		$sortDir = "ASC";
		
		#Build the where statement
		$andQueryArray = array();
		
		if(!empty($chemicals)){ array_push($andQueryArray, build_OR($chemicals, "chemical_name='", "'"));}
		if($minGenes != 0){ array_push($andQueryArray, "number_genes_with_data >= $minGenes");}

		$where = build_AND($andQueryArray);
		
		#Do the search
		$result = database_select_search($search, $table, $where, $sortedBy, $sortDir);

		# Throw the results into an array
		$resultArray = array();
		
		while ($row = mysql_fetch_assoc($result)){
			array_push($resultArray, $row);
		}

		#database dc
		database_disconnect();

		#return the results array
		if(count($resultArray) == 0){return "EMPTY";}	# Is the array empty?	
		return $resultArray;
	}
	function search_chemicalEnrichment($chemicals, $type = ""){
		if(!database_connect()){ return "DB_CONNECT_FAILURE"; }
		if(empty($genes) && empty($chemicals)){ return "NO_SEARCH"; }

		# Set up parameters of a basic chemicalENRICHMENT search
		$search = "*";
		$table = "chemicalEnrichment";
		$sortedBy = "p_value";
		
		#Build the where statement
		$andQueryArray = array();
		
		if(!empty($chemicals)){ array_push($andQueryArray, build_OR($chemicals, "chemical_name='", "'"));}

		if($type == "resistant") {
			array_push($andQueryArray, " (sensitivity_type = 'resistant') ");
		} else if ($type == "sensitive") {
			array_push($andQueryArray, " (sensitivity_type = 'sensitive') ");
		}

		$where = build_AND($andQueryArray);
		
		#Do the search
		$result = database_select_search($search, $table, $where, $sortedBy);

		# Throw the results into an array
		$resultArray = array();
		
		while ($row = mysql_fetch_assoc($result)){
			array_push($resultArray, $row);
		}

		#database dc
		database_disconnect();

		#return the results array
		if(count($resultArray) == 0){return "EMPTY";}	# Is the array empty?	
		return $resultArray;	
	}
	function search_chemicalEnrichmentGO($chemicals, $type = ""){
		if(!database_connect()){ return "DB_CONNECT_FAILURE"; }
		if(empty($genes) && empty($chemicals)){ return "NO_SEARCH"; }

		# Set up parameters of a basic chemicalENRICHMENTGO search
		$search = "*";
		$table = "chemicalEnrichmentGO";
		$sortedBy = "";
		
		#Build the where statement
		$andQueryArray = array();
		
		if(!empty($chemicals)){ array_push($andQueryArray, build_OR($chemicals, "chemical_name='", "'"));}

		array_push($andQueryArray, " (enrichment_type = 'GO') "); # Qualify to GO searches
		if($type == "resistant") {
			array_push($andQueryArray, " (sensitivity_type = 'resistant') ");
		} else if ($type == "sensitive") {
			array_push($andQueryArray, " (sensitivity_type = 'sensitive') ");
		}

		$where = build_AND($andQueryArray);
		
		#Do the search
		$result = database_select_search($search, $table, $where, $sortedBy);

		# Throw the results into an array
		$resultArray = array();
		
		while ($row = mysql_fetch_assoc($result)){
			array_push($resultArray, $row);
		}

		#database dc
		database_disconnect();

		#return the results array
		if(count($resultArray) == 0){return "EMPTY";}	# Is the array empty?	
		return $resultArray;	
	}

	function search_chemicalEnrichmentMC($chemicals, $type = ""){
		if(!database_connect()){ return "DB_CONNECT_FAILURE"; }
		if(empty($genes) && empty($chemicals)){ return "NO_SEARCH"; }

		# Set up parameters of a basic chemicalENRICHMENTMC search
		$search = "*";
		$table = "chemicalEnrichmentGO";
		$sortedBy = "";
		
		#Build the where statement
		$andQueryArray = array();
		
		if(!empty($chemicals)){ array_push($andQueryArray, build_OR($chemicals, "chemical_name='", "'"));}

		array_push($andQueryArray, " (enrichment_type = 'MC') "); # Qualify to MC searches
		if($type == "resistant") {
			array_push($andQueryArray, " (sensitivity_type = 'resistant') ");
		} else if ($type == "sensitive") {
			array_push($andQueryArray, " (sensitivity_type = 'sensitive') ");
		}

		$where = build_AND($andQueryArray);
		
		#Do the search
		$result = database_select_search($search, $table, $where, $sortedBy);

		# Throw the results into an array
		$resultArray = array();
		
		while ($row = mysql_fetch_assoc($result)){
			array_push($resultArray, $row);
		}

		#database dc
		database_disconnect();

		#return the results array
		if(count($resultArray) == 0){return "EMPTY";}	# Is the array empty?	
		return $resultArray;	
	}
*/
?>
