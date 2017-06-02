<?php
	session_start();
	
	if ( !isset ( $_SESSION['lecturerUsername'] ) || !isset ( $_SESSION['lecturerName'] ) )
	{
		header ( 'Location:indexLecturer.html' );
		die ( '' );
	}
?>
<!DOCTYPE html>
<html>
<head>
<title>Study Support Services</title>
<link rel='stylesheet' href='css/main.css'>
</head>
<body>
<div class='navbar'>
    <table width='100%'>
    <tr>
    	<td width='80%'><a>Admin Main Page</a></td>
        <td width='20%'><a href='lecturerLogout.php'>Logout</a></td>
    </tr>
    </table>
    </div>
<center>
<br /><br />
<br /><br />
<br /><br />
<br /><br />
<input type='button' value='View Appointments' onclick='location.href="lecturerViewAppointments.php"' /><br /><br />
<input type='button' value='Subject Management' onclick='location.href="lecturerSubjectManagement.php"' /><br /><br />
<input type='button' value='Resource Management' onclick='location.href="lecturerResourceManagement.php"' />
</center>
</body>
</html>
