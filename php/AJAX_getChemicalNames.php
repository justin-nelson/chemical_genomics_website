<?php
	require_once 'getNames.php';

	$resultArray = getChemicalList();
	
	# jsonencore ajax the array back
	echo(json_encode($resultArray));
	
	# DC from database
	database_disconnect();
?>
