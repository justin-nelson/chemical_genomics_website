<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	require_once 'mysql.php';
	require_once 'search_chemicalDatabase.php';
	require_once 'getNames.php';
	require_once 'getDatabaseIDs.php';

	// $_POST['query'] contains the raw query here, split it process it boil it salt it serve it
	$queryString = trim(strtoupper($_POST['query']), " \t,");
	$queryString = preg_replace('/;\s+/', ';', $queryString);
	$queryString = preg_replace('/\s+;/', ';', $queryString);
	$query = explode(";", $queryString);

	// Find where chemicals, genes and GOterms are in Query
	$chemicals = array_safe(array_intersect($query, array_map('strtoupper', getChemicalList() ) ));
	$genes = array_safe(array_intersect($query, array_map('strtoupper', getGeneList() ) ));
	$GOterms = array_safe(array_intersect($query, array_map('strtoupper', getGOList() ) ));
	
	$databaseIDs_chemicals = getChemicalDatabaseIDs($chemicals);
	$databaseIDs_genes = getGeneDatabaseIDs($genes);
	$databaseIDs_GOs = getGeneOntologyDatabaseIDs($GOterms);

	$results = array(
		0 => search_info_chemicals($databaseIDs_chemicals),
		1 => search_info_genes($databaseIDs_genes),
		2 => search_info_GO_terms($databaseIDs_GOs)
	);
 //echo $queryString;
	if($queryString == "" || $queryString == "NAME OF CHEMICALS TO SEARCH GOES HERE, SEPARATED BY;" ){
		echo "NO_SEARCH";
	} else if(count($chemicals) == 0 && count($genes) == 0 && count($GOterms) == 0){
		echo "INVALID_SEARCH";
	} else if(count($results[0]) == 0 && count($results[1]) == 0 && count($results[2]) == 0){ 
		echo "EMPTY"; 
	} else {
		echo json_encode($results);
	}
?>
