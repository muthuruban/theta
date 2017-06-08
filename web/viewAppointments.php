<?php
	session_start();
	
	if ( !isset ( $_SESSION['username'] ) || !isset ( $_SESSION['name'] ) )
	{
		header ( 'Location:index.html' );
		die ( '' );
	}

	$studentUsername = $_SESSION['username'];
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

<h2>View Appointments</h2>

<h2>View Appointments</h2>

<table id='myTable'>
<tr class='header'>
    <th>Subject</th>
    <th>Advisor</th>
    <th>Date</th>
    <th>Time</th>
    <th>Topic</th>
</tr>
<?php
require_once ( 'database.php' );

$connection = OpenDatabase();

$result = QueryDatabase ( $connection, 'SELECT "Subject","Advisor","Date","Time","Topic" FROM "Scheduled Appointments" WHERE "Student"=' . "'$studentUsername' ORDER BY \"Subject\" ASC,\"Advisor\" ASC,\"Topic\" ASC" );

$numAppointments = GetNumRows ( $result );

for ( $appointmentIndex = 0; $appointmentIndex < $numAppointments; ++$appointmentIndex )
{
    $subject = ReadField ( $result, $appointmentIndex, 'Subject' );
    $advisor = ReadField ( $result, $appointmentIndex, 'Advisor' );
    $date = ReadField ( $result, $appointmentIndex, 'Date' );
    $time = ReadField ( $result, $appointmentIndex, 'Time' );
    $topic = ReadField ( $result, $appointmentIndex, 'Topic' );
  
    echo "<tr>\n";
    echo "    <td>$subject</td>\n";
    echo "    <td>$advisor</td>\n";
    echo "    <td>$date</td>\n";
    echo "    <td>$time</td>\n";
    echo "    <td>$topic</td>\n";
    echo "</tr>\n";
}

CloseDatabase ( $connection );
?>
</table><br />

<input type='button' value='Back' onclick='location.href="main.php"' />

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
