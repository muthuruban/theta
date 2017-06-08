<?php
	session_start();

	if ( !isset ( $_SESSION['username'] ) || !isset ( $_SESSION['name'] ) )
	{
		header ( 'Location:index.html' );
		die ( '' );
	}
	
	if ( !isset ( $_GET['subject'] ) )
	{
		header ( 'Location:main.php' );
		die ( '' );
	}

	$subject = $_GET['subject'];

	if ( !isset ( $_GET['supportID'] ) )
	{
		header ( 'Location:scheduleOneToOneAppointments.php?subject=' . $subject );
		die ( '' );
	}

	$supportID = $_GET['supportID'];

    require_once ( 'database.php' );

	$connection = OpenDatabase();
	
	$result = QueryDatabase ( $connection, 'SELECT "Name","Day",to_char("Available Time Start",\'FMHH24\') AS "Time Start",to_char("Available Time End",\'FMHH24\') AS "Time End" FROM "General Support Staffing","Lecturer Profile" WHERE "ID"=' . $supportID );
	
	$lecturerName = ReadField ( $result, 0, 'Name' );
	$day = ReadField ( $result, 0, 'Day' );
	$timeStart = ReadField ( $result, 0, 'Time Start' );
	$timeEnd = ReadField ( $result, 0, 'Time End' );

	$result = QueryDatabase ( $connection, 'SELECT to_char("a",\'YYYY-MM-DD\') AS "Next Available Date",to_char("a",\'FMDay, FMDDth FMMonth YYYY\') AS "Formatted Date" FROM generate_series (current_date + \'1 day\'::interval, current_date + \'7 days\'::interval, \'1 day\') AS s(a) WHERE to_char(a,\'FMDay\')=' . "'$day'" );

	if ( GetNumRows ( $result ) == 1 )
	{
	    $nextAvailableDate = ReadField ( $result, 0, 'Next Available Date' );
	    $formattedDate = ReadField ( $result, 0, 'Formatted Date' );
	}
	else
	{
		$nextAvailableDate = '';
		$formattedDate = '---';
	}
	
	CloseDatabase ( $connection );
?>
<!DOCTYPE html>
<html>
<head>
<title>Study Support Services</title>
<link rel='stylesheet' href='css/main.css'>
<script type='text/javascript'>
function Book ( hour )
{
	location.href = 'scheduleAppointmentDetails.php?subject=<?php echo $subject; ?>&supportID=<?php echo $supportID; ?>&hour=' + hour
}
</script>
</head>
<body>

<div class='navbar'>
<table width='100%'>
<tr>
<?php
	require_once ( 'database.php' );

	$connection = OpenDatabase();
	
	$result = QueryDatabase ( $connection, 'SELECT "Subject Name" FROM "Subjects"' );
	
	$numSubjects = GetNumRows ( $result );
	
	$width = 100 / ( $numSubjects + 3 );
	
	for ( $subjectIndex = 0; $subjectIndex < $numSubjects; ++$subjectIndex )
	{
		$subjectName = ReadField ( $result, $subjectIndex, 'Subject Name' );
		
		echo "<td width='$width%'>";

		if ( $subjectName === $subject )
			echo "<a>$subjectName</a>";
		else
			echo "<a href='scheduleOneToOneAppointments.php?subject=$subjectName'>$subjectName</a>";

		echo "</td>\n";
	}
	
	CloseDatabase ( $connection );

	echo "<td width='$width%'>&nbsp;</td>\n";
	echo "<td width='$width%'><a href='viewAppointments.php'>View Appointments</a></td>\n";
	echo "<td width='$width%'><a href='logout.php'>Logout</a></td>\n";
?>
</tr>
</table>
</div>

<h2><?php echo $lecturerName; ?>'s Available Time</h2>

<h2><?php echo $lecturerName; ?>'s Available Time</h2>

<center>
<table style='width:50%' id='myTable'>
<tr class='header'>
    <th width='50%'>Time</th>
    <th width='50%'><?php echo $formattedDate; ?></th>
</tr>
<?php
	for ( $hour = 8; $hour <= 17; ++$hour )
	{
		echo "<tr>\n";
		
		if ( $hour < 12 )
			echo "    <td align='center'>0$hour:00</td>\n";
		else
			echo "    <td align='center'>$hour:00</td>\n";
		
		if ( $hour >= $timeStart && $hour < $timeEnd )
		    echo "    <td align='center'><input type='button' value='Book' onclick='Book($hour)' /></td>\n";
		else
		    echo "    <td>&nbsp;</td>\n";

		echo "</tr>\n";
	}
?>
</table>

<input type='button' value='Back' onclick='location.href="main.php?subject=<?php echo $subject; ?>"' style='width:70%' />

</center>

</body>
</html>
