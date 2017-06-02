<?php
	$subject = $_POST['subject'];
	
	require_once ( 'database.php' );
	
	$connection = OpenDatabase();
	
	$result = QueryDatabase ( $connection, 'SELECT COUNT(*) AS "Exist Count" FROM "Subjects" WHERE "Subject Name"=' . "'$subject'" );
	
	$isExist = ( ReadField ( $result, 0, 'Exist Count' ) > 0 );
	
	if ( $isExist )
	{
		QueryDatabase ( $connection, 'DELETE FROM "Subjects" WHERE "Subject Name"=' . "'$subject'" );
		$status = 'OK';
	}
	else
		$status = 'Not found';
	
	CloseDatabase ( $connection );
	
	die ( $status );
?>
