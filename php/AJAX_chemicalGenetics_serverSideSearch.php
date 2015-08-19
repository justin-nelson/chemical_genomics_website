<?php
	require_once 'constants.php';
	/*
	* Script:    DataTables server-side script for PHP and MySQL
	* Copyright: 2010 - Allan Jardine, 2012 - Chris Wright
	* License:   GPL v2 or BSD (3-point)
	*/

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	* Easy set variables
	*/

	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	* you want to insert a non-database field (for example a counter or static image)
	*/
	$aColumns = array( 	'c.chemical_name', 
				'o.standard_name', 
				'o.systematic_name', 
				'TRUNCATE(i.score,4)', 
				'c.in_high_confidence');

	$aColumn_names = array( 'chemical_name',
				'standard_name',
				'systematic_name',
				'TRUNCATE(i.score,4)',
				'in_high_confidence');
     
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "i.pid";
     
	/* DB table to use */
	$sTable = $GLOBALS["TABLE_CHEMICAL_GENETIC_INTERACTION"]." as i, ".$GLOBALS["TABLE_CHEMICAL_NAMES"]." as c, ".$GLOBALS["TABLE_GENE_NAMES"]." as o";
     
	/* Database connection information */
	require_once '../prv/ps.php';
	$gaSql['user']       = $GLOBALS["UN"];
	$gaSql['password']   = $GLOBALS["PS"];
	$gaSql['db']         = $GLOBALS["DB"];
	$gaSql['server']     = $GLOBALS["SN"];
     
     
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * If you just want to use the basic configuration for DataTables with PHP server-side, there is
     * no need to edit below this line
     */
     
    /*
     * Local functions
     */
    function fatal_error ( $sErrorMessage = '' ) {
        header( $_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error' );
        die( $sErrorMessage );
    }
 
     
    /*
     * MySQL connection
     */
    if ( ! $gaSql['link'] = mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) ) {
        fatal_error( 'Could not open connection to server' );
    }
 
    if ( ! mysql_select_db( $gaSql['db'], $gaSql['link'] ) ) {
        fatal_error( 'Could not select database ' );
    }
     
     
    /*
     * Paging
     */
    $sLimit = "";
    if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
    {
	if($_GET['iDisplayLength'] == 0) { $_GET['iDisplayLength'] = 198; }
        $sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".
            intval( $_GET['iDisplayLength'] );
    }
     
     
    /*
     * Ordering
     */
    $sOrder = "";
    if ( isset( $_GET['iSortCol_0'] ) ) {
        $sOrder = "ORDER BY  ";
        for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) {
            if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) {
                $sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
                    ".($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
            }
        }
         
        $sOrder = substr_replace( $sOrder, "", -2 );
        if ( $sOrder == "ORDER BY" ) {
            $sOrder = "";
        }
    }
     
     
    /*
     * Filtering
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here, but concerned about efficiency
     * on very large tables, and MySQL's regex functionality is very limited
     */
    $sWhere = "";
    if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
    {
        $sWhere = "WHERE (";
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" )
            {
                $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
            }
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';
    }
     
    /* Individual column filtering */
    for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
        if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
        {
            if ( $sWhere == "" )
            {
                $sWhere = "WHERE ";
            }
            else
            {
                $sWhere .= " AND ";
            }
            $sWhere .= $aColumns[$i]." LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
        }
    }
     

	// Modify the swhere variable for the actual search that we are doing
	if ( $sWhere == "" ){ $sWhere = "WHERE "; } else { $sWhere .= " AND "; }
	$sWhere .= " i.chemid = c.pid AND i.geneid = o.pid AND ";

	if($_GET['PID'] != ""){
		if($_GET['searchType'] == "CHEMICAL"){
			$sWhere .= "i.chemid = '".mysql_real_escape_string($_GET['PID'])."'";
     		} elseif($_GET['searchType'] == "GENE"){
			$sWhere .= "i.geneid = '".mysql_real_escape_string($_GET['PID'])."'";
		} else {
			$sWhere .= "1 = 0";
		}

		/*
		* SQL queries
		* Get data to display
		*/
		$sQuery = "SELECT ".str_replace(" , ", " ", implode(", ", $aColumns))." FROM $sTable $sWhere $sOrder $sLimit";
		$rResult = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );

		// Data set length after filtering
		$sQuery = "SELECT COUNT(*) FROM $sTable $sWhere";
		$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
		$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
		$iFilteredTotal = $aResultFilterTotal[0];

		// Total data set length 
		$sQuery = "SELECT COUNT(".$sIndexColumn.") FROM $sTable";
		$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
		$aResultTotal = mysql_fetch_array($rResultTotal);
		$iTotal = $aResultTotal[0];


		//
		// Output
		//
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);

		while ( $aRow = mysql_fetch_array( $rResult ) )
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] == "version" )
				{
					// Special output formatting for 'version' column 
					$row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
				}
				else if ( $aColumns[$i] != ' ' )
				{
					// General output 
					$row[] = $aRow[ $aColumn_names[$i] ];
				}
			}
			$output['aaData'][] = $row;
		}
	} else {
		// There is no chemical to search and I don't want to search the entire table ever.
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
	}
	echo json_encode( $output );
?>
