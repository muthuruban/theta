<?php
	session_start();
	
	if ( !isset ( $_SESSION['lecturerUsername'] ) || !isset ( $_SESSION['lecturerName'] ) )
	{
		header ( 'Location:indexLecturer.html' );
		die ( '' );
	}

	$lecturerUsername = $_SESSION['lecturerUsername'];
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
    	<td width='80%'><a>View Appointments</a></td>
        <td width='20%'><a href='lecturerLogout.php'>Logout</a></td>
    </tr>
    </table>
    </div>
<center>
<br /><br />
<br /><br />
<br /><br />
<br /><br />
<table id='myTable'>
<tr class='header'>
    <th>Subject</th>
    <th>Student</th>
    <th>Date</th>
    <th>Time</th>
    <th>Topic</th>
</tr>
<?php
	require_once ( 'database.php' );
	
	$connection = OpenDatabase();
	
	$result = QueryDatabase ( $connection, 'SELECT "Subject","Name","Date","Time","Topic" FROM "Scheduled Appointments","Student Profile" WHERE "Student"="Username" AND "Advisor"=' . "'$lecturerUsername'" );
	
	$numAppointments = GetNumRows ( $result );
	
	for ( $appointmentIndex = 0; $appointmentIndex < $numAppointments; ++$appointmentIndex )
	{
		$subject = ReadField ( $result, $appointmentIndex, 'Subject' );
		$studentName = ReadField ( $result, $appointmentIndex, 'Name' );
		$date = ReadField ( $result, $appointmentIndex, 'Date' );
		$time = ReadField ( $result, $appointmentIndex, 'Time' );
		$topic = ReadField ( $result, $appointmentIndex, 'Topic' );
		
		echo "<tr>\n";
		echo "    <td>$subject</td>\n";
		echo "    <td>$studentName</td>\n";
		echo "    <td>$date</td>\n";
		echo "    <td>$time</td>\n";
		echo "    <td>$topic</td>\n";
		echo "</tr>\n";
	}
	
	CloseDatabase ( $connection );
?>
</table><br />
<input type='button' value='Back' onclick='location.href="lecturerMain.php"' />
</center>
</body>
</html>
