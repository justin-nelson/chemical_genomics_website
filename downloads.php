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
		<p> Hello! Welcome to the batch downloader made-in-a-day </p>
		<p> This is what webpages look like after I make them functional and before I make them pretty </p>
		<div><textarea id="inputList" rows="4"></textarea></div>
		<button type="button" id="chemicalSearch" onclick="chemicalSearch($('#inputList').val())">Search</button>
		<div id="chemicalTable">grergrergehergergergehrg</div>
	<!--START JAVASCRIPT-->
		<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
		<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
		<script>
			function chemicalSearch(query){
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

						}
					}
				});
			}

		</script>
	<!--END JAVASCRIPT-->
	</body>
</html>
