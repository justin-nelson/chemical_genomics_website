////////////////////////////////////////////////////////////////////////////////
// Options for the script
////////////////////////////////////////////////////////////////////////////////
VIEWPORT_HEADER = "#header_search";
VIEWPORT_FOOTER = "#footer_search";
INFOTABLE_CONTROL_DIV = "#info_control";
TABLE_CONTROL_DIV = "#table_control";
CHEMICAL_PICTURE_DIV = "#chemical_picture";
CHEMICAL_INFO_TABLE_DIV = "#chemicalInfo_tables";
TABLE_DIV = "#tables";
BOTTOM_DIV = "#bottom";

FDR_P_VALUE_CUTOFF = 0.00028; // *~* OBSOLETE ~*~ //
FDR_CUTOFF = 0.25; // *~* OBSOLETE ~*~ //

STARTING_TABLE = 0;

////////////////////////////////////////////////////////////////////////////////
// Variables for the script
////////////////////////////////////////////////////////////////////////////////
var infoDataTable = "";
var info_tables = [];
var tables = [];
tables.current = "";

var currentPID = "";
var currentSearchType = "";

////////////////////////////////////////////////////////////////////////////////
// INFOTABLES
////////////////////////////////////////////////////////////////////////////////
info_tables.aliases = ["CHEMICAL", "GENE", "GO"]
info_tables[0] = {	data:"", 
			dataTable:"", 
			loadfunction:loadChemicalInfoTable, 
			tableDiv:"#infotable_conditions", 
			div:"#infotable_conditions_div", 
			li:"#infotable_conditions_li", 
			ssSource:"regular", 
			type:"INFO", 
			columns:[ { "sType": "allnumeric", "aTargets": [] } ], 
			possibleTables: [0,3,4,1,2]
		}; 
info_tables[1] = {	data:"", 
			dataTable:"", 
			loadfunction:loadGeneInfoTable, 
			tableDiv:"#infotable_genes", 
			div:"#infotable_genes_div", 
			li:"#infotable_genes_li", 
			ssSource:"regular", 
			type:"INFO", 
			columns:[ { "sType": "allnumeric", "aTargets": [] } ], 
			possibleTables: [3,4]
		}; 
info_tables[2] = {	data:"", 
			dataTable:"", 
			loadfunction:loadGOInfoTable, 
			tableDiv:"#infotable_GO_terms", 
			div:"#infotable_GO_terms_div", 
			li:"#infotable_GO_terms_li", ssSource:"regular", type:"INFO", columns:[ { "sType": "allnumeric", "aTargets": [] } ], possibleTables: [0]
		}; 
////////////////////////////////////////////////////////////////////////////////
// TABLES
////////////////////////////////////////////////////////////////////////////////
tables[0] = 	{	data:"", 
			dataTable:"", 
			tableDiv:"#processPrediction_table", 
			div:"#processPrediction_div", 
			li:"#processPrediction_li", 
			ssSource:"php/AJAX_processPrediction_serverSideSearch.php", 
			type:"PROCPRED", 
			columns:[], 
			possibleSearches: ["CHEMICAL", "GO"], 
			FDR25_index: 7, /* Which column in the table says 1/0 for is_FDR25 */
			defaultSort: [[3, "asc"], [4, "desc"]],
			currentSort: [[3, "asc"], [4, "desc"]],
			};
tables[1] = 	{	data:"", 
			dataTable:"", 
			tableDiv:"#chemicalSimilarity_table", 
			div:"#chemicalSimilarity_div", 
			li:"#chemicalSimilarity_li", 
			ssSource:"php/AJAX_chemicalSimilarity_serverSideSearch.php", 
			type:"CHEMSIMI", 
			columns:[], 
			possibleSearches: ["CHEMICAL"], 
			FDR25_index: 3,
			defaultSort: [[2, "desc"]],
			currentSort: [[2, "desc"]],
			};
tables[2] = 	{	data:"", 
			dataTable:"", 
			tableDiv:"#profileSimilarity_table", 
			div:"#profileSimilarity_div", 
			li:"#profileSimilarity_li", 
			ssSource:"php/AJAX_profileSimilarity_serverSideSearch.php", 
			type:"PROFSIMI", 
			columns:[], 
			possibleSearches: ["CHEMICAL"], 
			FDR25_index: 3,
			defaultSort: [[2, "desc"]],
			currentSort: [[2, "desc"]],
			};
tables[3] = 	{	data:"", 
			dataTable:"", 
			tableDiv:"#genePrediction_table", 
			div:"#genePrediction_div", 
			li:"#genePrediction_li", 
			ssSource:"php/AJAX_genePrediction_serverSideSearch.php", 
			type:"GENEPRED", 
			columns:[], 
			possibleSearches: ["CHEMICAL", "GENE"], 
			FDR25_index: 4,
			defaultSort: [[3, "desc"]],
			currentSort: [[3, "desc"]],
			};
tables[4] = 	{	data:"", 
			dataTable:"", 
			tableDiv:"#chemicalGenetics_table", 
			div:"#chemicalGenetics_div", 
			li:"#chemicalGenetics_li", 
			ssSource:"php/AJAX_chemicalGenetics_serverSideSearch.php", 
			type:"CHEMGENE", 
			columns:[], 
			possibleSearches: ["CHEMICAL", "GENE"], 
			FDR25_index: 4,
			defaultSort: [[3, "asc"]],
			currentSort: [[3, "asc"]],
			};

////////////////////////////////////////////////////////////////////////////////
// resetVisibility()
// This will use javascript to make sure everything is the same visibility as
// when the webpage was loaded.
////////////////////////////////////////////////////////////////////////////////
function resetVisibility(){
	$(VIEWPORT_HEADER).show();
	$(VIEWPORT_FOOTER).show();
	$(INFOTABLE_CONTROL_DIV).hide();
	$(BOTTOM_DIV).hide();
}
///////////////////////////////////////////////////////////////
// loadResults (override basicDatabaseSearch:loadResults)
// unloadResults
// This function will handle the results from a database search
// It will execute checkFunction to check to see if the results are good before loading them in
////////////////////////////////////////////////
function loadResults(results, checkFunction){
	destroyAllTables(info_tables);
	unloadResults();
	hideAllTableDivs(info_tables);

	currentPID = "";
	currentSearchType = "";

	for(var i=0; i<info_tables.length; i++){
		if(!checkFunction(results[i])){ info_tables[i].data = results[i];}
	}
}

function unloadResults(){
	for(var i=0; i<info_tables.length; i++){
		info_tables[i].data = '';
	}
}

///////////////////////////////
// Expand/Contract Info Table
// Expands or Contracts the info table
//////////////////////////////////
function expandInfoTable(){
	selection = $('#chemicalInfo_table').find('tr.selected').attr('name');
	createChemicalInfoTable('295px', selection, tables.current);
	//$("#chemical_picture").height($("#chemicalInfo_superTable").height() - 50);
	$("#chemical_picture").height(400);
	$("#expandContract").html('<a onclick="contractInfoTable()">contract...</a>');
}
function contractInfoTable(){
	selection = $('#chemicalInfo_table').find('tr.selected').attr('name');
	createChemicalInfoTable('95px', selection, tables.current);
	$("#chemical_picture").height(200);
	$("#expandContract").html('<a onclick="expandInfoTable()">expand...</a>');
}

////////////////////////////////////////////////////////////////////////////////
// setupChemicalInfoTable (override basicDatabaseSearch:setupInfoTable)
// This function will setup the info table, which will then be used to control 
// which data is displayed in other tables
////////////////////////////////////////////////////////////////////////////////
function setupChemicalInfoTable(){
	unloadAllTableData(info_tables); // Clear the data currently in the dataTables including info table
	hideAllTableDivs(info_tables); // Hide the data tables
	createChemicalInfoTable('400px', 0, STARTING_TABLE);
	showTableControls();
	fixAllDataTableHeader(info_tables);
}

////////////////////////////////////////////////////////////////////////////////
function createChemicalInfoTable(height, selection, currentTable){
	$(INFOTABLE_CONTROL_DIV).show();
	for(var i=0; i<info_tables.length; i++){
		destroyTable(i, info_tables); // Destroy the DataTable for the chemical info
		loadInfoTable(i, info_tables);
		info_tables[i].dataTable = convertToDataTable(i, height, info_tables);
		//if(info_tables[i].data.length != 0) { showTable(i, info_tables); }
		//fixDataTableHeader(i, info_tables); // Make sure the header is properly aligned
		if(info_tables[i].data == "") { 
			hideLi(i, info_tables);
		} else {
			showLi(i, info_tables);
		}
		setupInfoTableClick(i, info_tables);
	}
	initialSelectChemicalInfoTable(selection, currentTable, info_tables);
}

function initialSelectChemicalInfoTable(selection, currentTable, table_ref){
	$(CHEMICAL_INFO_TABLE_DIV).find("a").removeClass("selected");
	for(var i = 0; i < table_ref.length; i++){
		if(table_ref[i].data != ""){ 
			table_index = i; 
			$(table_ref[i].li).children( "a" ).trigger("click");
			break; 
		}
	}
	row_index = 0;

	$(table_ref[table_index].div).find('tbody').find('tr[name]').first().addClass("selected");
	loadDatabaseTables(table_index, row_index, currentTable, table_ref);
}
/////////////////////////////////////////////////////////////////
// convertToDataTable()
// converts an existing table into a datatable
////////////////////////////////////////////////////////
var sortOrder = {};
function convertToDataTable(index, size, table_ref){
	destroyTable(index, table_ref);

	if(table_ref[index].ssSource == "regular" || table_ref[index].ssSource == undefined || table_ref[index].ssSource == ""){
		var dataTable = $(table_ref[index].tableDiv).dataTable({
			"sScrollY": size,
			"bPaginate": false,
			"bScrollCollapse": true,
			"bLengthChange": false,
			"bInfo": false,
			"bFilter": false,
			//"sPaginationType": "full_numbers",
			"aoColumnDefs": table_ref[index].columns,
		});
	} else {
		// This will add classes to the rows as they come in
		//rowCreated_fn = function( nRow, aData, iDisplayIndex ) { return nRow; }
		rowCreated_fn = function( nRow, aData, iDisplayIndex ) {
			if(aData[tables[index].FDR25_index] == "0"){
				nRow.className = 'missFDRCutoff';
				return nRow;
			}
		}
		

		var dataTable = $(table_ref[index].tableDiv).dataTable( {
			"fnRowCallback": rowCreated_fn,
			"sScrollY": size,
			"sAjaxSource": table_ref[index].ssSource,
			"bServerSide": true,
			"sDom": "frtS",
			"oScroller": {
				"loadingIndicator": false
			},
			"aoColumnDefs": table_ref[index].columns,
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "PID", "value": currentPID } );
				aoData.push( { "name": "searchType", "value": currentSearchType } );
			},
			"aaSorting": table_ref[index].currentSort,
		} );
		dataTable.fnSort( table_ref[index].defaultSort );
	}

	return dataTable;	
}
////////////////////////////////////////////////////////////////////////////////
// Functions to be run when this script is loaded
////////////////////////////////////////////////////////////////////////////////
$(window).resize(function() {
	if(this.resizeTO) clearTimeout(this.resizeTO);
	this.resizeTO = setTimeout(function() {
		if(tables.current !== ""){ tables[tables.current].dataTable.fnAdjustColumnSizing(); }
		fixAllDataTableHeader(info_tables);
		//$(this).trigger('resizeEnd');
	}, 100);
});
////////////////////////////////////////////////////////////////////////////////




////////////////////////////////////////////////////////////////////////////////
// LoadXInfoTable
// These are different ways to load the info table
////////////////////////////////////////////////////////////////////////////////
function loadInfoTable(index, table_ref){
	table_ref[index].loadfunction(index, table_ref);
}
function loadChemicalInfoTable(index, table_ref){
	str = ''; // Start Creating the table

	// Create Table
	curIndex = 0;
	for (var i in table_ref[index].data){
		str = str + '<tr name="'+curIndex+'">';
			if(table_ref[index].data[i].structure_pic == ""){ table_ref[index].data[i].structure_pic = "unhappy.jpg" }

//table_ref[index].data[i].structure_pic == null|table_ref[index].data[i].structure_pic == ""?"mr_yuk.svg":table_ref[index].data[i].structure_pic
			//str = str + '<td name="structure" align="center">' + "<img src='structures/" + tables[index].data[i].structure_pic +"' height='100px' width='100px' /></td>";
			str = str + '<td align="center">' + "<img src='structures/"+table_ref[index].data[i].structure_pic+"' height='100px' />" + '</td>';			
			str = str + '<td>' + table_ref[index].data[i].chemical_identifier + '</td>';
			str = str + '<td>' + (table_ref[index].data[i].concentration == null?'':table_ref[index].data[i].concentration) + '</td>';
			str = str + '<td class="smile_string">' + (table_ref[index].data[i].smile_structure == null?'':table_ref[index].data[i].smile_structure) + '</td>';
			str = str + '<td>' + (table_ref[index].data[i].bioactivity == null?'':table_ref[index].data[i].bioactivity.substr(0,5)) + '</td>';
			//str = str + '<td>' + (table_ref[index].data[i].top_process_prediction == null?'':table_ref[index].data[i].top_process_prediction) + '</td>';
			str = str + '<td>' + (table_ref[index].data[i].molecular_weight == null?'':table_ref[index].data[i].molecular_weight) + '</td>';
			str = str + '<td>' + table_ref[index].data[i].dataset + '</td>';
		str = str + '</tr>';
		curIndex = curIndex+1;
	}

	$(table_ref[index].tableDiv).find("tbody").html(str); // Throw down table
}
function loadGeneInfoTable(index, table_ref){
	str = ''; // Start Creating the table

	// Create Table
	curIndex = 0;
	for (var i in table_ref[index].data){
		str = str + '<tr name="'+curIndex+'">';
			//str = str + '<td name="structure" align="center">' + "<img src='structures/" + tables[index].data[i].structure_pic +"' height='100px' width='100px' /></td>";
			str = str + '<td>' + '<a href="http://www.yeastgenome.org/locus/' + table_ref[index].data[i].primary_DBID+'/overview" target="_blank">' + table_ref[index].data[i].standard_name + '</a>' + '</td>';
			str = str + '<td>' + table_ref[index].data[i].systematic_name + '</td>';
			str = str + '<td>' + table_ref[index].data[i].gene_name + '</td>';
			str = str + '<td>' + table_ref[index].data[i].gene_alias + '</td>';
			//str = str + '<td>' + '<a href="http://www.yeastgenome.org/locus/' + table_ref[index].data[i].primary_DBID+'/overview" target="_blank">[SGD]</a>' + '</td>';
		str = str + '</tr>';
		curIndex = curIndex+1;
	}

	$(table_ref[index].tableDiv).find("tbody").html(str); // Throw down table
}
function loadGOInfoTable(index, table_ref){
	str = ''; // Start Creating the table

	// Create Table
	curIndex = 0;
	for (var i in table_ref[index].data){
		str = str + '<tr name="'+curIndex+'">';
			//str = str + '<td name="structure" align="center">' + "<img src='structures/" + tables[index].data[i].structure_pic +"' height='100px' width='100px' /></td>";
			str = str + '<td>' + table_ref[index].data[i].GO_name + '</td>';
			str = str + '<td>' + table_ref[index].data[i].GO_desc + '</td>';
		str = str + '</tr>';
		curIndex = curIndex+1;
	}

	$(table_ref[index].tableDiv).find("tbody").html(str); // Throw down table
}
////////////////////////////////////////////////////////////////////////////////



////////////////////////////////////////////////////////////////////////////////
// setupInfoTableClick
// This will set it up so that when the infoTable is clicked, additional data is loaded
////////////////////////////////////////////////////////////////////////////////
function setupInfoTableClick(index, table_ref){
	$(table_ref[index].tableDiv).find('tbody tr').click(function() {
		// Destroy the current table while I load in the new data
		tmp_currentTable = tables.current;

		row_index = $(this).attr('name');
		
		loadDatabaseTables(index, row_index, tables.current, table_ref);
		
		for(var i=0; i<table_ref.length; i++){ $(info_tables[i].tableDiv).find("tr.selected").removeClass("selected") }
		$(this).addClass("selected");
	});
}

function loadDatabaseTables(table_index, row_index, currentTable, table_ref){
	currentPID = table_ref[table_index].data[row_index].pid;
	currentSearchType = table_ref[table_index].data[row_index].searchType;
	createTable(currentTable, row_index, table_ref); // recreate the table that the website was on
	//tables.current = currentTable;
}

function setupSimilarityTableClick(index){
	$(tables[index].tableDiv).find('tbody tr').click(function() {
		var row_index = $(this).attr('name');
		$('#query').val( tables[index].data[row_index]['chemical2_name'] );
		basicDatabaseSearch(tables[index].data[row_index]['chemical2_name']);
	});
}
////////////////////////////////////////////////////////////////////////////////
// function createTable
// Set everything up for the table
///////////
function createTable(index, row_index, table_ref){
	if(index === "") { return; }
	if(currentSearchType === "") { return; }
	destroyCurrentTable();
	showAppropriateTables(row_index);
	index = determineAppropriateTable(index);
	tables.current = index;

	// This is a fix for idTabs not showing the chemicalSGA tab after a new search
	$(TABLE_CONTROL_DIV).find( "a" ).removeClass( "selected" );
	//$("a.selected").removeClass( "selected" );
	$(tables[index].li).children( "a" ).addClass( "selected" );
	//$(tables[index].li).children( "a" ).trigger("click");
	// End fix *~*
	
	tables[index].dataTable = convertToDataTable(index, '500px', tables);
	hideAllTableDivs(tables);
	showTable(index, tables);
	tables[index].dataTable.fnAdjustColumnSizing()
}

////////////////////////////////////////////////////////////////////////////////
// function showAppropriateTables
// This function will show tables that are appropriate for the current type
// of search
////////////////////////////////////////////////////////////////////////////////
function showAppropriateTables(row_index){	
	hideAllLi(tables);
	if(currentSearchType === ""){ return; }
	for(i in info_tables[info_tables.aliases.indexOf(currentSearchType)].possibleTables){
		showLi(info_tables[info_tables.aliases.indexOf(currentSearchType)].possibleTables[i], tables);
	}
}
//////////////////////////////////////////
// function determineAppropriateTable
// This function will take the current search type and use it to determine
// the correct table index to display, avoiding tables that are not visible
////////////////////////////////////////////////////////////////////////////////
function determineAppropriateTable(index){
	if(currentSearchType === ""){ return ""; }
	if(tables[index].possibleSearches.indexOf(currentSearchType) < 0){
		return info_tables[info_tables.aliases.indexOf(currentSearchType)].possibleTables[0];
	}
	return index;
}



function destroyTable(index, table_ref){
	if(table_ref[index].dataTable != ""){
		if(table_ref[index].dataTable.html() != undefined){
			table_ref[index].dataTable.fnDestroy();
		}
		table_ref[index].dataTable = "";
	}
}

function destroyCurrentTable(){
	if(tables.current !== ""){
		destroyTable(tables.current, tables);
	}
}

function destroyAllTables(table_ref){
	for(var i=0; i<table_ref.length; i++){
		destroyTable(i, table_ref);
	}
}

////////////////////////////////////////////////////////////////////////////////
// Show and hide li elements
///////////////////
function showLi(index, table_ref){ $(table_ref[index].li).show(); }
function hideLi(index, table_ref){ $(table_ref[index].li).hide(); }
function hideAllLi(table_ref){
	for(var i=0; i<table_ref.length; i++){ hideLi(i, table_ref); }
}
function showAllLi(table_ref){
	for(var i=0; i<table_ref.length; i++){ showLi(i, table_ref); }
}

/////////////////////////
// LoadChemicalPicture
// loads up the chemical picture
//////////////////////
function loadChemicalPicture(picture){
	if(picture != ''){
		$(CHEMICAL_PICTURE_DIV).html("<img src='structures/"+picture+"' height='100%' />");
	} else {
		$(CHEMICAL_PICTURE_DIV).html("");
	}
}

//////////////////////////////////////////////
// Load and unload Table Data
function loadTableData(){}
// Destroy the data inside of the tables
function unloadAllTableData(table_ref){
	for(var i=0; i<table_ref.length; i++){
		unloadTableData(i, table_ref);
	}
}
function unloadTableData(index, table_ref){
	$(table_ref[index].tableDiv).find("tbody").html("");
}

///////////////////////////////////////////////////////////
// Fix columns
// Fixes the header of the dataTable
///////////////
function fixAllDataTableHeader(table_ref){
	for(var i=0; i<table_ref.length; i++){
		fixDataTableHeader(i, table_ref);
	}
}
function fixDataTableHeader(index, table_ref){
	if(table_ref[index].datatable !== ""){ table_ref[index].dataTable.fnAdjustColumnSizing();}
}

/////////////////////////////////////////////////////////////////
// showTable()
// hideTable()
// Show or hide a table div based on what is loaded into the tables variable
// hideAllTableDivs()
// Hide all of the divs for the tables if they are shown.
/////////////////////////////////////////////////////////////////
function showTable(index, table_ref){
	$(table_ref[index].div).show();
}
function hideTable(index, table_ref){
	$(table_ref[index].div).hide();
}
function hideAllTableDivs(table_ref){
	for(var i=0; i<table_ref.length; i++){
		hideTable(i, table_ref);
	}
}
//////////////////////////////////////////////////////////////////
// showTableControls()
// hideTableControls
// Show or hide the table controls and the tables
function showTableControls(){
	$(TABLE_CONTROL_DIV).show();
	$(TABLE_DIV).show();
	$(BOTTOM_DIV).show();
	$(VIEWPORT_HEADER).hide();
	$(VIEWPORT_FOOTER).hide();
}
function hideTableControls(){
	$(TABLE_CONTROL_DIV).hide();
	$(TABLE_DIV).hide();
	$(BOTTOM_DIV).hide();
	$(VIEWPORT_HEADER).show();
	$(VIEWPORT_FOOTER).show();
}



////////////////
// When the document is ready, load some custom sorting functions
// Sorting functions
/////////////
$(document).ready( function(){
	// new sorting functions 
	jQuery.fn.dataTableExt.oSort['allnumeric-asc']  = function(a,b) {
		if(a == "nan"){ return -1; }
		if(b == "nan"){ return 1; }
		var x = parseFloat(a);
		var y = parseFloat(b);
		return ((x < y) ? -1 : ((x > y) ?  1 : 0));
	};
	 
	jQuery.fn.dataTableExt.oSort['allnumeric-desc']  = function(a,b) {
		if(a == "nan"){ return -1; }
		if(b == "nan"){ return 1; }
		var x = parseFloat(a);
		var y = parseFloat(b);
		return ((x < y) ? 1 : ((x > y) ?  -1 : 0));
	};
});
