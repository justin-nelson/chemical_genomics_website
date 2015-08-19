<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<?php require("html/title.html");?>

		<!--START STYLESHEET-->
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
		<link rel="stylesheet" href="css/universal.css">
		<link rel="stylesheet" href="css/search.css">
		<link rel="stylesheet" href="css/autocomplete.css">
		<link rel="stylesheet" href="css/idtabs.css">
		<!--END STYLESHEET-->
	</head>
	<body>
		<!-- Submit button and query text box -->
		<div id="input">
			<div id="header_search" class="perc50_viewportHeight centered">
				<img src="images/mosaic_logo2.png" />
			</div>
			<div id="inputbox" class="pixel15_topbottomMargins">
				<input type="text" id="query" class="searchbox" value="" size=70/>
				<button type="button" name="basicDatabaseSearch" id="basicDatabaseSearch" onclick='basicDatabaseSearch($("#query").val(), "FALSE")'>Search</button>
				<a href="bug.php"> Bugtracker! </a>
			</div>
			<div id="footer_search" class="pixel50_leftrightMargins centered">
				<div id="status" ></div>
				<p> If you name it, you must logo it, and they will come. </p>
			</div>
		</div>	
		<!-- Select Chemical, chemical information -->
		<div id="info_control" style="display: none;" class="idtabs_background" border=1>
			<div id="chemicalInfo_tables" class="usual" border=1>
				<ul class="idTabs"> 
					<li id="infotable_conditions_li"><a class="selected" href="#infotable_conditions_div">Conditions</a></li> 
					<li id="infotable_genes_li"><a href="#infotable_genes_div">Genes</a></li> 
					<li id="infotable_GO_terms_li"><a href="#infotable_GO_terms_div">GO Terms</a></li> 
				</ul>
			</div>
			<div id="infoTables" class="datatables_background">
				<?php require("html/conditions_infoTable.html");?>
				<?php require("html/genes_infoTable.html");?>
				<?php require("html/GO_terms_infoTable.html");?>
			</div>
		</div>
		<!-- Display results of search -->
		<div id="bottom" style="display: none;" class="idtabs_background">
			<div id="table_control" class="usual" style="display: none;">
				<ul class="idTabs">
					<li id="processPrediction_li"><a href="#processPrediction_div">Process-level Target Predictions</a></li>
					<li id="genePrediction_li"><a href="#genePrediction_div">Gene-level Target Predictions</a></li>
					<li id="chemicalGenetics_li"><a href="#chemicalGenetics_div" class="selected">Chemical Genetic Profile</a></li>
					<li id="chemicalSimilarity_li"><a href="#chemicalSimilarity_div">ChemSIM</a></li>
					<li id="profileSimilarity_li"><a href="#profileSimilarity_div">ProfSIM</a></li>
				</ul>
			</div>
			<div id="tables" class="datatables_background" style="display: none;">
				<?php require("html/processPrediction_table.html");?>
				<?php require("html/genePrediction_table.html");?>
				<?php require("html/chemicalGenetics_table.html");?>
				<?php require("html/chemicalSimilarity_table.html");?>
				<?php require("html/profileSimilarity_table.html");?>
			</div>
		</div>
		<!--START JAVASCRIPT-->
		<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
		<script type="text/javascript" src="js/setupAutocomplete.js"></script>
		<script type="text/javascript" src="js/databaseSearch.js"></script>
		<script type="text/javascript" src="js/search_tableControls.js"></script>
		<script type="text/javascript" src="js/DataTables-1.10.4/media/js/jquery.dataTables.js"></script>
		<!--script type="text/javascript" src="js/DataTables-1.10.4/extensions/Scroller/js/dataTables.scroller.js"></script-->
		<!--script type="text/javascript" src="js/jquery.dataTables.js"></script-->
		<script type="text/javascript" src="js/Scroller-1.1.0/media/js/dataTables.scroller.js"></script>
		<script type="text/javascript" src="js/jquery.idTabs.min.js"></script>
		<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>

		<script>
			// This is the setup for the tabs on the tables
			$("#chemicalInfo_tables ul").idTabs(function(id,list,set){ 
				$("a",set).removeClass("selected").filter("[href='"+id+"']",set).addClass("selected"); 
				for(i in list) { $(list[i]).hide(); }
				$(id).fadeIn(); 
				fixAllDataTableHeader(info_tables);
				return false; 
			}); 
		</script>
		<script>
			$("#table_control ul").idTabs(function(id){ 
				switch(id){ 
					case "#processPrediction_div": createTable(0); break; 
					case "#genePrediction_div": createTable(3); break; 
					case "#chemicalGenetics_div": createTable(4); break; 
					case "#chemicalSimilarity_div":  createTable(1); break; 
					case "#profileSimilarity_div":  createTable(2); break;
				} return true; 
			}); 
			setupAutocomplete("#query", "php/AJAX_getAllNames.php");
		</script>
		<script>
			var ENTER_KEY = 13;
			// Allow an enter to complete the search rather than having to push the submit button
			$("input").keypress(function(e){
				if (e.which == ENTER_KEY) {
					e.preventDefault();
					basicDatabaseSearch($('#query').val());
				}
			});
		</script>
		<script> showStatus = true; </script>
		<script> 
			/////////////////////////////////////////////////////////
			// This is a script that controls the search box, and what happens when it loses and gains focus
			////////////////
			defaultSearchText = "name of chemicals to search goes here, separated by ;";
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
