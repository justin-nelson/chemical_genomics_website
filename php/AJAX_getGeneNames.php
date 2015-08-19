<?php
	require_once 'getNames.php';

	$resultArray = getGeneList();
	
	# jsonencore ajax the array back
	echo(json_encode($resultArray));
	
	# DC from database
	database_disconnect();
?>
