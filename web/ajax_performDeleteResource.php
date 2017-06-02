<?php
	$resourceID = $_POST['resourceID'];
	
	require_once ( 'database.php' );
	
	$connection = OpenDatabase();
	
	$result = QueryDatabase ( $connection, 'SELECT "Resource OID" FROM "Resources" WHERE "Resource ID"=' . $resourceID );
	
	if ( GetNumRows ( $result ) > 0 )
	{
		$resourceOID = ReadField ( $result, 0, 'Resource OID' );
		
		QueryDatabase ( $connection, "SELECT lo_unlink ( $resourceOID )" );
		
		QueryDatabase ( $connection, 'DELETE FROM "Resources" WHERE "Resource ID"=' . $resourceID );
		$status = 'OK';
	}
	else
		$status = 'Not found';
	
	CloseDatabase ( $connection );
	
	die ( $status );
?>
