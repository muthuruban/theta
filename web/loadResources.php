<?php
	$sheetNumber = $_GET['sheetNumber'];
	$oid = $_GET['oid'];
	
	require_once ( 'database.php' );

   	$connection = OpenDatabase();
	
    pg_query ( $connection, 'BEGIN' );
	
	$loid = pg_loopen ( $connection, $oid, 'r' );

    header ( 'Content-type: application/pdf' );

    pg_loreadall ( $loid );
    pg_loclose ( $loid );
	
    QueryDatabase ( $connection, 'COMMIT' );
	
	CloseDatabase ( $connection );
?>
