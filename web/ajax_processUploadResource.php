<?php
$uploadDirectory = 'resourceUploads/';
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
	$resourceFilename = $_FILES [ 'fileToUpload' ] [ 'name' ];
	$resourcePath = $uploadDirectory . $resourceFilename;
	move_uploaded_file ( $_FILES [ 'fileToUpload' ] [ 'tmp_name' ], $resourcePath );
	
	require_once ( 'database.php' );

	$connection = OpenDatabase();

	QueryDatabase ( $connection, 'BEGIN' );

	$oid = pg_lo_import ( $connection, 'C:\\Program Files (x86)\\PostgreSQL\\EnterpriseDB-ApachePHP\\apache\\www\\theta\\' . $resourcePath );

	QueryDatabase ( $connection, 'COMMIT' );

	CloseDatabase ( $connection );
	
	unlink ( $resourcePath );

	die ( "OK$oid" );
}
?>
