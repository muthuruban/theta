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

<h2><?php echo $subject; ?> One-to-One Schedule</h2>

<h2><?php echo $subject; ?> One-to-One Schedule</h2>

<center>
<table style='width:70%' id='myTable'>
<tr class='header'>
    <th width='30%'>Advisor</th>
    <th width='70%'>Next Available</th>
</tr>
<?php
require_once ( 'database.php' );

$connection = OpenDatabase();

$result = QueryDatabase ( $connection, 'SELECT "ID","Name","Day" FROM "General Support Staffing","Lecturer Profile" WHERE "Lecturer Username"="Username" AND "Subject"=' . "'$subject'" . ' ORDER BY "Name" ASC' );

$numEntries = GetNumRows ( $result );

for ( $entryIndex = 0; $entryIndex < $numEntries; ++$entryIndex )
{
    $id = ReadField ( $result, $entryIndex, 'ID' );
    $lecturerName = ReadField ( $result, $entryIndex, 'Name' );
    $day = ReadField ( $result, $entryIndex, 'Day' );

	$result2 = QueryDatabase ( $connection, 'SELECT to_char("a",\'FMDay, FMDDth FMMonth YYYY\') AS "Next Available Date" FROM generate_series (current_date + \'1 day\'::interval, current_date + \'7 days\'::interval, \'1 day\') AS s(a) WHERE to_char(a,\'FMDay\')=' . "'$day'" );

	if ( GetNumRows ( $result2 ) == 1 )
	    $nextAvailableDate = ReadField ( $result2, 0, 'Next Available Date' );
	else
		$nextAvailableDate = '---';

    echo "<tr align='center'>\n";
	echo "    <td><a href='scheduleAppointmentTime.php?subject=$subject&supportID=$id'>$lecturerName</a></td>\n";
	echo "    <td>$nextAvailableDate</td>\n";
	echo "</tr>\n";
}

CloseDatabase ( $connection );
?>
</table>

<input type='button' value='Back' onclick='location.href="main.php?subject=<?php echo $subject; ?>"' style='width:70%' />

</center>

</body>
</html>
