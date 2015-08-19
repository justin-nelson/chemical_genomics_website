<?php
	error_reporting(E_ALL);
	ini_set('display_errors', '1');

	require_once 'mysql.php';
	require_once 'search_chemicalDatabase.php';
	require_once 'getNames.php';

	$queryString = trim(strtoupper($_POST['query']), " \t,");
	$queryString = preg_replace('/\s+[;|\n]\s+/', ';', $queryString);
	$query = explode(";", $queryString);

	// Find where chemicals, genes and GOterms are in Query
	$chemicals = array_safe(array_intersect($query, array_map('strtoupper', getChemicalList() ) ));
	$genes = array_safe(array_intersect($query, array_map('strtoupper', getGeneList() ) ));
	$GOterms = array_safe(array_intersect($query, array_map('strtoupper', getGOList() ) ));
	
	// Grab the results
	$chemicalProperties_result = search_chemicalProperties($chemicals);

	echo json_encode($chemicalProperties_result);
?>
