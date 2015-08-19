<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<?php require("html/title.html");?>

		<!--START STYLESHEET-->
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
		<style type="text/css" href="css/universal.css" ></style>
		<style>
			#inputList { width: 100%; }
		</style>
	</head>
	<body>
		<p> Hello! Welcome to the chemical property browser. </p>
		<p> Input a list of chemicals, either seperated by ";" or by a newline. </p>
		<p> When the database is updated with the latest GO information (likely after we finalize Z-score), I will add the ability to find information about chemicals with a GO enrichment.</p>
		<p> If you find any bugs, as always please add them to <a href="bug.php">the bug tracker</a>.</p>
		<div><textarea id="inputList" rows="4"></textarea></div>
		<button type="button" id="chemicalSearch" onclick="chemicalPropertySearch($('#inputList').val())">Search</button>
		<div id="chemicalTable"></div>
	<!--START JAVASCRIPT-->
		<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
		<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
		<script>
			CHEMICAL_TABLE_DIV = "#chemicalTable";

			// Perform the database search for the chemicalProperties
			function chemicalPropertySearch(query){
				$.ajax({
					url : 'php/AJAX_chemicalPropertySearch.php',
					type : 'post',
					data : {
						query:query
					},
					success : function(answer){
						if(answer == "DB_CONNECT_FAILURE"){ alert("Database Connection Failure"); }
						else if(answer == "NO_SEARCH"){ alert("Invalid or No Search Query specified"); }
						else if(answer == "EMPTY"){ alert("Nothing returned"); }
						else {
							results = eval(answer);
							create_chemicalPropertyBrowser(results);
						}
					}
				});
			}
			
			// Create the table to be displayed in the chemicalTable div
			function create_chemicalPropertyBrowser(results){
				str = "";			
				str = str + "<table border='1'>";
				str = str + "<tr>";
				str = str + "<th>Name</th>";
				str = str + "<th>Structure</th>";
				str = str + "<th>molecular_weight</th>";
				str = str + "<th>bioactivity</th>";
str = str + "<th>top_proc_pred</th>";
str = str + "<th>top_5_proc_pred</th>";
				str = str + "<th>h_bond_acceptors</th>";
				str = str + "<th>h_bond_donor</th>";
				str = str + "<th>rotatable_bonds</th>";
				str = str + "<th>ring_count</th>";
				str = str + "<th>log_d</th>";
				str = str + "<th>log_p</th>";
				str = str + "<th>lead_likeness</th>";
				str = str + "<th>lipinski_rule_of_5</th>";
				str = str + "<th>bioavailability</th>";
				str = str + "</tr>";

				for( var i=0; i< results.length; i++ ){
					str = str + "<tr>";
					str = str + "<td>" + results[i].name + "</td>";
					str = str + "<td>" + "<img src='structures/"+results[i].structure_pic+"' >" + "</td>";
					str = str + "<td>" + results[i].molecular_weight + "</td>";
					str = str + "<td>" + results[i].bioactivity + "</td>";
					str = str + "<td>" + results[i].top_process_prediction + "</td>";
					str = str + "<td>" + results[i].top_5_process_prediction + "</td>";
					str = str + "<td>" + results[i].H_bond_acceptors + "</td>";
					str = str + "<td>" + results[i].H_bond_donors + "</td>";
					str = str + "<td>" + results[i].rotatable_bonds + "</td>";
					str = str + "<td>" + results[i].ring_count + "</td>";
					str = str + "<td>" + results[i].log_d + "</td>";
					str = str + "<td>" + results[i].log_p + "</td>";
					str = str + "<td>" + results[i].lead_likeness + "</td>";
					str = str + "<td>" + results[i].lipinski_rule_of_5 + "</td>";
					str = str + "<td>" + results[i].bioavailability + "</td>";
					str = str + "</tr>";
				}
				str = str + "</table>";

				$(CHEMICAL_TABLE_DIV).html(str); // Throw it in!
			}
		</script>
	<!--END JAVASCRIPT-->
	</body>
</html>
