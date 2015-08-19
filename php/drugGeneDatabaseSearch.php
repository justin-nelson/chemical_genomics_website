<?php
	require_once '../mysql.php';

	#Connect to the database
	if(!database_connect()){ echo "DB_CONNECT_FAILURE"; return false; }
	
	#Process the input
	$drug = safe($_POST['drug']);
	$gene = safe($_POST['gene']);
	
	$needAnd = false;
	
	$search = "*";
	$table = "interactions";
	$sortedBy = "chemgen_score";
	$where = "";
	
	if($drug != ""){ $where .= ($needAnd?"AND ":"")."drug_name = '$drug' "; $needAnd=true; }
	if($gene != ""){ $where .= ($needAnd?"AND ":"")."(orf_name = '$gene' OR common_name = '$gene') "; $needAnd=true; }
	

	//$where = "drug_name = '$drug' AND (orf_name = '$gene' OR common_name = '$gene')";
	if($drug != "" || $gene != ""){ 
		#Do a database search
		$result = database_select_search($search, $table, $where, $sortedBy);

		# Throw the results into an array
		$resultArray = array();
		while ($row = mysql_fetch_assoc($result)){
			array_push($resultArray, $row);
		}
		
		# jsonencore ajax the array back
		echo(json_encode($resultArray));
	} else { echo "NO_SEARCH"; }
	# DC from database
	database_disconnect();
?>
