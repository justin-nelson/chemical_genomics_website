<?php
	require_once 'getNames.php';

	#$resultArray = array_merge( getChemicalList(), getGOList() );
	$resultArray = getAllList();

	# jsonencore ajax the array back
	echo(json_encode($resultArray));
	
	# DC from database
	database_disconnect();
?>
