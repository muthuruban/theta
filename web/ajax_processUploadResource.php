<?php
$temp = explode ( '.', $_FILES [ 'fileToUpload' ] [ 'name' ] );
$extension = end ( $temp );

if ( $extension !== 'pdf' )
    die ( 'Invalid extension' );

if ( $_FILES [ 'fileToUpload' ] [ 'error' ] > 0 )
{
	die ( 'Error code: ' . $_FILES [ 'fileToUpload' ] [ 'error' ] );
}
else
{
	require_once ( 'database.php' );

	$connection = OpenDatabase();

	QueryDatabase ( $connection, 'BEGIN' );

	$oid = pg_locreate ( $connection );

	$handle = pg_loopen ( $connection, $oid, 'w' );
	$fp = fopen (  $_FILES [ 'fileToUpload' ] [ 'tmp_name' ], 'r' );

	while ( !feof ( $fp ) )
		pg_lowrite ( $handle, fread ( $fp, 4096 ) );

	fclose ( $fp );

	pg_loclose ( $handle );

	QueryDatabase ( $connection, 'COMMIT' );

	CloseDatabase ( $connection );
	
	unlink ( $resourcePath );

	die ( "OK$oid" );
}
?>
