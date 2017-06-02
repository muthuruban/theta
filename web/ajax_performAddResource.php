<?php
	$subject = $_POST['subject'];
	$topic = $_POST['topic'];
	$sheetNumber = $_POST['sheetNumber'];
	$title = $_POST['title'];
	$resourceOID = $_POST['resourceOID'];
	
	require_once ( 'database.php' );
	
	$connection = OpenDatabase();
	
	$result = QueryDatabase ( $connection, 'SELECT "ID" FROM "Worksheet and Test Categories" WHERE "Subject"=' . "'$subject'" . ' AND "Category"=' . "'$topic'" );
	
	if ( GetNumRows ( $result ) == 0 )
	{
		$result = QueryDatabase ( $connection, 'INSERT INTO "Worksheet and Test Categories" ("Subject","Category") VALUES ' . "('$subject','$topic') RETURNING \"ID\"" );
		$id = ReadField ( $result, 0, 'ID' );

		QueryDatabase ( $connection, 'INSERT INTO "Resources" ("Worksheet and Test ID","Sheet Number","Title","Resource OID") VALUES ' . "($id,'$sheetNumber','$title',$resourceOID)" );
		$status = 'OK';
	}
	else
	{
		$id = ReadField ( $result, 0, 'ID' );

		$result = QueryDatabase ( $connection, 'SELECT COUNT(*) AS "Duplicate Count" FROM "Resources" WHERE "Worksheet and Test ID"=' . $id . ' AND "Sheet Number"=' . "'$sheetNumber'" . ' AND "Title"=' . "'$title'" );
		
		$isDuplicate = ( ReadField ( $result, 0, 'Duplicate Count' ) > 0 );

		if ( !$isDuplicate )
		{
			QueryDatabase ( $connection, 'INSERT INTO "Resources" ("Worksheet and Test ID","Sheet Number","Title","Resource OID") VALUES ' . "($id,'$sheetNumber','$title',$resourceOID)" );
			$status = 'OK';
		}
		else
			$status = 'Duplicate';
	}
	
	CloseDatabase ( $connection );
	
	die ( $status );
?>
