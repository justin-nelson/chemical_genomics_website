///////////////////////////////////
// Default options for this script
///////////////////////////////////
showStatus = false; // This will show the status of the search in the #status div

///////////////////////////////////
// This is for memorizing a search history
///////////////////////////////////
searchHistory = new Array();

///////////////////////////////////
// Search History functions
///////////////////////////////////
function addSearchToHistory(query){
	searchHistory.push(query);
	trimSearchHistory();
}

function trimSearchHistory(){
	if(searchHistory.length > 10){searchHistory.shift();}
}

///////////////////////////////////
// checkResultsforErrors
// Check the results of a database search, handle the error and return true
// else return false.
//////////////////////////////////
function checkResultsforErrors(results){
	if(results == "DB_CONNECT_FAILURE") { return true; }
	if(results == "NO_SEARCH"){return true; }
	if(results == "EMPTY"){return true; }
	if(results == ""){return true; }
	return false;
}

///////////////////////////////////
// basicDatabaseSearch
// Perform a database search of the passed query string.
///////////////////////////////////
function basicDatabaseSearch(query, getMultiplex){
	//if(showStatus) {$('#status').html('<br><br>Performing a search for '+query+'.<br><br>')}; // This should be more indicative of what is going on.
	if(typeof getMultiplex === 'undefined'){ getMultiplex = "FALSE"; };
	$.ajax({
		url : 'php/AJAX_databaseSearch.php',
		type : 'post',
		data : {
			query:query,
			getMultiplex:getMultiplex
		},
		success : function(answer){
			//if(showStatus) {$('#status').html('<br><br>Results retrieved for '+query+', parsing tables.<br><br>')};

			if(answer == "DB_CONNECT_FAILURE"){ alert("Database Connection Failure"); }
			else if(answer == "NO_SEARCH"){ 
				resetVisibility();
				$('#status').html('<br><br>Your search for nothing has returned nothing.<br><br>Please enter a list of compounds, genes, or gene ontology terms separated by semicolons into the search box.');
			} else if(answer == "INVALID_SEARCH"){
				resetVisibility();
				$('#status').html('<br><br>Your search for "'+query+'" did not match any compounds, genes, or gene ontology terms in the database.<br><br>Please enter a list of compounds, genes, or gene ontology terms separated by semicolons into the search box.');
			} else if(answer == "EMPTY"){ 
				resetVisibility();
				$('#status').html('<br><br>Your search for "'+query+'" did not match any compounds, genes, or gene ontology terms in the database.<br><br>Please enter a list of compounds, genes, or gene ontology terms separated by semicolons into the search box.');
			} else {
				results = eval(answer);
				loadResults(results, checkResultsforErrors); // Load results
				delete results; // Clear the results so we don't take up all that memory twice
				setupChemicalInfoTable();
				if(showStatus) {$('#status').html('')};
			}
			addSearchToHistory(query);
		}
	});
}


/////////////////////////////////////////////////
// Overridable function:loadResults
// Used to handle the data coming from the basicDatabaseSearch
// Overridable function:setupChemicalInfoTable
// Sets up the chemicalInfotable
////////////////////////
function loadResults(results, checkFunction){ return false;};
function setupChemicalInfoTable(){}
