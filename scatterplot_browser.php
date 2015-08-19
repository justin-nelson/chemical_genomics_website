<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<?php require("html/title.html");?>

		<!--START STYLESHEET-->
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
		<style type="text/css" href="css/universal.css" />
		<style>
			.ui-autocomplete {
				max-height: 200px;
				overflow-y: auto;
				/* prevent horizontal scrollbar */
				overflow-x: hidden;
			}
			/* IE 6 doesn't support max-height
			* we use height instead, but this forces the menu to always be this tall
			*/
			* html .ui-autocomplete {
				height: 100px;
			}

			

			#info_control {
				height: 100%;
				overflow: hidden;
			}
			#chemicalInfo_superTable {
				height: 100%;
				width: 100%;
			}
			#chemicalInfo_table{}
			#chemicalInfo_table tbody tr:hover {
				background-color: #ccc;
			}
			#chemicalInfo_table tbody tr.selected {
				background-color: yellow;
			}
			#chemical_picture {
				height: 100%;
			}
			
			.fixedHeader {}
		</style>
		<style>
			.box {
			    background: none repeat scroll 0 0 white;
			    border-color: #071419;
			    border-radius: 12px 12px 12px 12px;
			    border-style: solid;
			    border-width: 1.5px;
			}

			.leftFloat {
				float: left;
				position: relative;
			}
			
			.rightFloat {
				float: right;
				position: relative;
			}
		</style>
		<style>
			/* Style for idTabs */
			.usual {
				background:#181818;
				color:#111;
				padding: 15px 15px 0;
				padding-left: 0;
				border:1px solid #222;
				border-bottom-width: 0;
				margin:8px auto;
				margin-bottom: 0;
			}
			.usual li { list-style:none; float:left; }
			.usual ul {
				height: 27px;
    				margin-bottom: 0;
    				margin-top: 0;
				padding-left: 10px;
			}
			.usual ul a {
				display:block;
				padding:6px 10px;
				text-decoration:none!important;
				margin:1px;
				margin-left:0;
				font:10px Verdana;
				color:#FFF;
				background:#444;
			}
			.usual ul a:hover {
				color:#FFF;
				background:#111;
			}
			.usual ul a.selected {
				margin-bottom:0;
				color:#000;
				background:snow;
				border-bottom:1px solid snow;
				cursor:default;
			}
			.usual div {
				padding:10px 10px 8px 10px;
				*padding-top:3px;
				*margin-top:-15px;
				clear:left;
				background:snow;
				font:10pt Georgia;
			}
			.usual div a { color:#000; font-weight:bold; }

		</style>

		<style>
			.paging_full_numbers a.paginate_button {
				background-color: #DDDDDD;
			}
			.paging_full_numbers a.paginate_button, .paging_full_numbers a.paginate_active {
				border: 1px solid #AAAAAA;
				color: #333333 !important;
				cursor: pointer;
				margin: 0 3px;
				padding: 2px 5px;
			}
		</style>
		<style>
			#tables {
				margin: 10px;
				margin-top: 0;
				background: #FFF;
				padding: 5px;
			}

			#bottom {
				background:#111;
				padding: 5px;
			}

			.searchbox {
				color: #888;
			}

			#inputbox {
				width: 1000px;
				display: block;
				margin-left: auto;
				margin-right: auto;
			}
		</style>
		<!--END STYLESHEET-->
		
	</head>
	<body>
		<!-- Submit button and query text box -->
		<div id="input">
			<div id="inputbox">
				<input type="text" id="query" class="searchbox" value="" size=70/>
				<button type="button" name="basicDatabaseSearch" id="basicDatabaseSearch" onclick='basicDatabaseSearch($("#query").val(), "TRUE")'>Search</button>
				<a href="bug.php"> Bugtracker! </a>
			</div>
			<div id="status"></div>
		</div>		
		<div id="info_control" style="display: none;">
			<table id="chemicalInfo_superTable" border=1>
				<td width=25%><div id="chemical_picture" align="center" valign="middle"></div></td>
				<td width=75% valign="top">
					<div>
						
						<p> Select a condition from the following table. </p>
						<table border=1 id="chemicalInfo_table">
							<thead>
								<!--th>Structure</th-->
								<th>Name</th>
								<th>Multiplex</th>
								<th>Lane</th>
								<th>Replicate</th>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</td>
			</table>
			<div id="expandContract"> <a onclick="contractInfoTable()">contract...</a> </div>
		</div>
		<div id="bottom" style="display: none;">
			<div id="table_control" class="usual" style="display: none;">
				<ul class="idTabs">
					<li><a href="#processPrediction_div">Process-level Target Predictions</a></li>
					<li><a href="#genePrediction_div">Gene-level Target Predictions</a></li>
					<li><a href="#chemicalGenetics_div" class="selected">Chemical Genetic Profile</a></li>
					<li><a href="#chemicalSimilarity_div">ChemSIM</a></li>
					<li><a href="#profileSimilarity_div">ProfSIM</a></li>
					<!--li><a href="#scatterplots_div">SCATTER</a></li-->
				</ul>
			</div>
			<div id="tables" style="display: none;">
				<?php require("html/processPrediction_table.html");?>
				<?php require("html/genePrediction_table.html");?>
				<?php require("html/chemicalGenetics_table.html");?>
				<?php require("html/chemicalSimilarity_table.html");?>
				<?php require("html/profileSimilarity_table.html");?>
				<!--?php require("html/scatterplots_table.html");?>
				<!--div id="scatterplots" style="display: none;"></div-->
			</div>
		</div>

	<!--START JAVASCRIPT-->
		<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
		<script type="text/javascript" src="js/setupAutocomplete.js"></script>
		<script type="text/javascript" src="js/basicDatabaseSearch.js"></script>
		<script type="text/javascript" src="js/basicSearchTableControl.js"></script>
		<script type="text/javascript" src="js/jquery.dataTables.js"></script>
		<script type="text/javascript" src="js/Scroller-1.1.0/media/js/dataTables.scroller.js"></script>
		<script type="text/javascript" src="js/jquery.idTabs.min.js"></script>
		<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>

		<script>
			// This is the setup for the tabs on the tables
			$("#table_control ul").idTabs(function(id){ 
				switch(id){ 
					case "#processPrediction_div": createTable(1); break; 
					case "#genePrediction_div": createTable(4); break; 
					case "#chemicalGenetics_div": createTable(5); break; 
					case "#chemicalSimilarity_div":  createTable(2); break; 
					case "#profileSimilarity_div":  createTable(3); break; 
					//case "#scatterplots_div":  showScatterplots(); break;
				} return true; 
			}); 
			setupAutocomplete("#query", "php/AJAX_getAllNames.php");
		</script>
		<script>
			// Allow an enter to complete the search rather than having to push the submit button
			$("input").keypress(function(e){
				if (e.which == 13) {
					e.preventDefault();
					basicDatabaseSearch($('#query').val());
				}
			});
		</script>
		<script>
			
		</script>
		<script> showStatus = true; </script>
		<script> 
			/////////////////////////////////////////////////////////
			// This is a script that controls the search box, and what happens when it loses and gains focus
			////////////////
			defaultSearchText = "name of chemicals to search goes here, seperated by ;";
			unfocusedTextColor = "#888";
			focusedTextColor = "#000";
			SEARCH_BOX_DIV = '#query';
			
			$(SEARCH_BOX_DIV).val(defaultSearchText); // Setup the default search box text
			$(SEARCH_BOX_DIV).css('color', unfocusedTextColor); // Setup the default search box text color
			// When the search box receives focus turn the value to blank if it's default text
			$(SEARCH_BOX_DIV).focus(function() {
				if($(SEARCH_BOX_DIV).val() == defaultSearchText){
					$(SEARCH_BOX_DIV).val(""); 
					$(SEARCH_BOX_DIV).css('color', focusedTextColor);
				}
			});

			// When the search box loses focus turn the value to default if it's blank
			$(SEARCH_BOX_DIV).blur(function() {
				if($(SEARCH_BOX_DIV).val() == ""){
					$(SEARCH_BOX_DIV).val(defaultSearchText); 
					$(SEARCH_BOX_DIV).css('color', unfocusedTextColor);
				}
			});
			
		</script>
		<!--END JAVASCRIPT-->
	</body>
</html>
