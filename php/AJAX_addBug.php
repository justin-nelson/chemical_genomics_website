<?php
	ini_set('display_errors', 1);

	$submitter = $_POST["submitter"];
	$description = $_POST["description"];
	$priority = $_POST["priority"];

	

	if($submitter != "" && $description != ""){
		// Order of replacement
		$order   = array("\r\n", "\n", "\r");
		$replace = '<br />';

		// Processes \r\n's first so they aren't converted twice.
		$description = str_replace($order, $replace, $description);

		$bugNumberFile = '../bugtracker/numBugs.txt';
		$bugtrackFile = '../bugtracker/bugs.txt';
		
		#grab the bug number count
		if(file_exists($bugNumberFile)){
			$bugNumHandle = fopen($bugNumberFile, 'r');
			$bugNumber = fread($bugNumHandle, filesize($bugNumberFile));
			$bugNumber = trim($bugNumber, "\n");
			echo $bugNumber;
			fclose($bugNumHandle);
			
			#write the new bug into the file
			if(file_exists($bugtrackFile)){
				$bugFileHandle = fopen($bugtrackFile, 'a');
				fwrite($bugFileHandle, $bugNumber."|".$submitter."|".$description."|Open|$priority|Notes...\n");
				fclose($bugFileHandle);
			}
			#update bug number count
			$bugNumHandle = fopen($bugNumberFile, 'w');
			fwrite($bugNumHandle, $bugNumber+1);
			fclose($bugNumHandle);
		}
	}
?>
