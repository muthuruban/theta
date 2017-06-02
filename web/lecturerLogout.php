<?php
	session_start();
	
	$_SESSION = Array();
	
	session_destroy();
	
	header ( 'Location:indexLecturer.html' );
?>
