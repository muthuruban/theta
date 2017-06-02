<?php
	$sheetNumber = $_GET['sheetNumber'];
	$oid = $_GET['oid'];
	
	require_once ( 'database.php' );

   	$connection = OpenDatabase();
	
    pg_query ( $connection, 'BEGIN' );
	
    pg_lo_export ( $connection, $oid, "C:\\Program Files (x86)\\PostgreSQL\\EnterpriseDB-ApachePHP\\apache\\www\\theta\\resources\\${sheetNumber}_$oid.pdf" );
	
    QueryDatabase ( $connection, 'COMMIT' );
	
	CloseDatabase ( $connection );
	
	header ( "Location:resources/${sheetNumber}_$oid.pdf" );
?>
