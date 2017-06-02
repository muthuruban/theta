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
	echo "<td width='10%'>";
	echo ( $subject === 'Theta' ) ? "<a>Theta</a>" : "<a href='scheduleOneToOneAppointments.php?subject=Theta'>Theta</a>";
	echo "</td>\n";

	echo "<td width='10%'>";
	echo ( $subject === 'Maths' ) ? "<a>Maths</a>" : "<a href='scheduleOneToOneAppointments.php?subject=Maths'>Maths</a>";
	echo "</td>\n";

	echo "<td width='20%'>";
	echo ( $subject === 'Programming' ) ? "<a>Programming Support</a>" : "<a href='scheduleOneToOneAppointments.php?subject=Programming'>Programming Support</a>";
	echo "</td>\n";
?>
	<td width='20%'>&nbsp;</td>
	<td width='20%'><a href='viewAppointments.php'>View Appointments</a></td>
    <td width='20%'><a href='logout.php'>Logout</a></td>
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
