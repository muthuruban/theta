<?php
	session_start();
	$_SESSION = Array();
	session_destroy();

	$username = $_POST['username'];
	$password = $_POST['password'];
	
	require_once ( 'database.php' );
	
	$connection = OpenDatabase();
	
	$result = QueryDatabase ( $connection, 'SELECT "Name" FROM "Lecturer Profile" WHERE "Username"=' . "'$username' AND \"Password\"='$password'" );
	
	if ( GetNumRows ( $result ) == 1 )
	{
		$name = ReadField ( $result, 0, 'Name' );
		$status = "OK`$name";
		
		session_start();
		$_SESSION['lecturerUsername'] = $username;
		$_SESSION['lecturerName'] = $name;
	}
	else
		$status = 'Invalid';
	
	CloseDatabase ( $connection );
	
	die ( $status );
?>
