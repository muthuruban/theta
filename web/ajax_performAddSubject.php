<?php
	$subject = $_POST['subject'];
	
	require_once ( 'database.php' );
	
	$connection = OpenDatabase();
	
	$result = QueryDatabase ( $connection, 'SELECT COUNT(*) AS "Duplicate Count" FROM "Subjects" WHERE "Subject Name"=' . "'$subject'" );
	
	$isDuplicate = ( ReadField ( $result, 0, 'Duplicate Count' ) > 0 );
	
	if ( !$isDuplicate )
	{
		QueryDatabase ( $connection, 'INSERT INTO "Subjects" ("Subject Name") VALUES (' . "'$subject')" );
		$status = 'OK';
	}
	else
		$status = 'Duplicate';
	
	CloseDatabase ( $connection );
	
	die ( $status );
?>
