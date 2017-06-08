<?php
	session_start();
	
	if ( !isset ( $_SESSION['username'] ) || !isset ( $_SESSION['name'] ) )
	{
		header ( 'Location:index.html' );
		die ( '' );
	}
	
	$subject = ( isset ( $_GET['subject'] ) ) ? $_GET['subject'] : 'Theta';
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
			echo "<a href='main.php?subject=$subjectName'>$subjectName</a>";

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

<h2><?php echo $subject; ?> Timetable</h2>

<h2><?php echo $subject; ?> Timetable</h2>

<h3>General support is available in the <?php echo $subject; ?> centre. Staffing is shown in the table below. The <?php echo $subject; ?> class room can be found behind Starbucks in the Engineering and Computing building.</h3>

<input type='text' id='myInput' onkeyup='Search(value.toUpperCase(),0)' placeholder='Search for names..' title='Type in a name' />

<input type='text' id='mysecond' onkeyup='Search(value.toUpperCase(),2)' placeholder='Search a day' title='Type in a day'>

<input type='text' id='mythird' onkeyup='Search(value.toUpperCase(),4)' placeholder='Search a specialisation' title='Type in a specialisation' />

<table id='myTable'>
<tr class='header'>
    <th>Name</th>
    <th>Email</th>
    <th>Day</th>
    <th>Time</th>
    <th>Specialisation</th>
</tr>
<?php
require_once ( 'database.php' );

$connection = OpenDatabase();

$result = QueryDatabase ( $connection, 'SELECT "Lecturer Username","Name","E-mail","Day",to_char("Available Time Start",\'HH24:MI\') AS "Available Time Start",to_char("Available Time End",\'HH24:MI\') AS "Available Time End","Specialisation" FROM "General Support Staffing","Lecturer Profile" WHERE "Lecturer Username"="Username" AND "Subject"=' . "'$subject'" );

$numLecturers = GetNumRows ( $result );

for ( $lecturerIndex = 0; $lecturerIndex < $numLecturers; ++$lecturerIndex )
{
    $lecturerUsername = ReadField ( $result, $lecturerIndex, 'Lecturer Username' );
    $lecturerName = ReadField ( $result, $lecturerIndex, 'Name' );
    $email = ReadField ( $result, $lecturerIndex, 'E-mail' );
    $day = ReadField ( $result, $lecturerIndex, 'Day' );
	$availableTimeStart = ReadField ( $result, $lecturerIndex, 'Available Time Start' );
	$availableTimeEnd = ReadField ( $result, $lecturerIndex, 'Available Time End' );
    $time = "$availableTimeStart - $availableTimeEnd";
    $specialisation = ReadField ( $result, $lecturerIndex, 'Specialisation' );
  
    echo "<tr>\n";
    echo "    <td>$lecturerName</td>\n";
    echo "    <td>$email</td>\n";
    echo "    <td>$day</td>\n";
    echo "    <td>$time</td>\n";
    echo "    <td>$specialisation</td>\n";
    echo "</tr>\n";
}

CloseDatabase ( $connection );
?>
</table>

<input type='button' value='Worksheets and Tests' onclick='location.href="worksheetsAndTests.php?subject=<?php echo $subject; ?>"' />&nbsp;<input type='button' value='Schedule One-to-One Appointments' onclick='location.href="scheduleOneToOneAppointments.php?subject=<?php echo $subject; ?>"' />

<script>
function Search ( filter, colIndex )
{
    var table, tr, td, i

    table = document.getElementById('myTable')
    tr = table.getElementsByTagName('tr')

    for ( i = 0; i < tr.length; ++i )
    {
        td = tr[i].getElementsByTagName('td') [ colIndex ]
    
	    if ( td )
	    {
            if ( td.innerHTML.toUpperCase().indexOf ( filter ) > -1 )
                tr[i].style.display = ''
            else
                tr[i].style.display = 'none'
        }
    }
}
</script>
</body>
</html>
