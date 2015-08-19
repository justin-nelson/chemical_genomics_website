<?php
	require_once 'getNames.php';

	$resultArray = getGOList();
	
	# jsonencore ajax the array back
	echo(json_encode($resultArray));
	
	# DC from database
	database_disconnect();
?>
