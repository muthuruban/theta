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

	if ( !isset ( $_GET['hour'] ) )
	{
		header ( "Location:scheduleAppointmentTime.php?subject=$subject&supportID=$supportID" );
		die ( '' );
	}

	$hour = $_GET['hour'];
?>
<!DOCTYPE html>
<html>
<head>
<title>Study Support Services</title>
<script type='text/javascript'>
/*
function Next()
{
	var contactNumber = document.getElementById('contactNumber').value
	if ( !VerifyText ( contactNumber, 'contact number' ) ) return

	var contactEmail = document.getElementById('contactEmail').value
	if ( !VerifyText ( contactEmail, 'contact e-mail' ) ) return

	var universityNumber = document.getElementById('universityNumber').value
	if ( !VerifyText ( universityNumber, 'university number' ) ) return

    var numberOfAttendeesEl = document.getElementById('numberOfAttendees')
	var numberOfAttendees = numberOfAttendeesEl.options [ numberOfAttendeesEl.selectedIndex ].value

	var degreeCourseName = document.getElementById('degreeCourseName').value
	if ( !VerifyText ( degreeCourseName, 'degree course name' ) ) return

	var qualificationStudiedFor = document.getElementById('qualificationStudiedFor').value
	if ( !VerifyText ( qualificationStudiedFor, 'qualification studied for' ) ) return

    var yearOfStudyEl = document.getElementById('yearOfStudy')
	var yearOfStudy = yearOfStudyEl.options [ yearOfStudyEl.selectedIndex ].value

	var topic = document.getElementById('topic').value
	if ( !VerifyText ( topic, 'topic' ) ) return

	location.href = 'scheduleVerification.php?subject=<?php $subject; ?>&supportID=<?php echo $supportID; ?>&hour=<?php echo $hour; ?>&contactNumber=' + contactNumber + '&contactEmail=' + contactEmail + '&universityNumber=' + universityNumber + '&numberOfAttendees=' + numberOfAttendees + '&degreeCourseName=' + degreeCourseName + '&qualificationStudiedFor= ' + qualificationStudiedFor + '&yearOfStudy=' + yearOfStudy + '&topic=' + topic
}
*/
function Back()
{
	location.href = 'scheduleAppointmentTime.php?subject=<?php echo $subject; ?>&supportID=<?php echo $supportID; ?>'
}
</script>
</head>
<body>
<link rel='stylesheet' href='css/login_style.css'>
<link rel='stylesheet' href='css/main.css'>
<h1>Theta Login</h1>
<form method='POST' action='scheduleVerification.php'>
	<input type='hidden' name='subject' value='<?php echo $subject; ?>' />
    <input type='hidden' name='supportID' value='<?php echo $supportID; ?>' />
    <input type='hidden' name='hour' value='<?php echo $hour; ?>' />
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
    
    <h2>Appointment Details</h2>
  
    <div class='container'>
    <table width='90%'>
    <tr>
    	<td width='40%'><label><b>Contact Number</b></label></td>
        <td width='60%'><input type='text' placeholder='Enter Contact Number' id='contactNumber' name='contactNumber' required /></td>
    </tr>
	<tr>
    	<td><label><b>Contact E-mail</b></label></td>
    	<td><input type='text' placeholder='Enter Contact E-mail' id='contactEmail' name='contactEmail' required /></td>
	</tr>
    <tr>
    	<td><label><b>University Number<br />(if applicable)</b></label></td>
    	<td><input type='text' placeholder='Enter University Number' id='universityNumber' name='universityNumber' /></td>
	</tr>
    <tr>
    	<td><label><b>Number of Attendees</b></label></td>
    	<td><select id='numberOfAttendees' name='numberOfAttendees'>
    <?php
	for ( $attendeeIndex = 1; $attendeeIndex <= 10; ++$attendeeIndex )
	    echo "    <option value='$attendeeIndex'>$attendeeIndex</option>\n";
	?>
    </select></td>
	</tr>
    <tr>
    	<td><label><b>Degree Course Name</b></label></td>
    	<td><input type='text' placeholder='Enter Degree Course Name' id='degreeCourseName' name='degreeCourseName' required /></td>
	</tr>
    <tr>
    	<td><label><b>Qualification Studied For</b></label></td>
    	<td><input type='text' placeholder='Enter Qualification Studied For' id='qualificationStudiedFor' name='qualificationStudiedFor' required /></td>
    </tr>
	<tr>
    	<td><label><b>Year of Study</b></label></td>
    	<td><select id='yearOfStudy' name='yearOfStudy'>
    <?php
	for ( $year = 2017; $year >= 2014; --$year )
	    echo "    <option value='$year'>$year</option>\n";
	?>
    </select></td>
    </tr>
	<tr>
    	<td><label><b>Topic</b></label></td>
    	<td><input type='text' placeholder='Enter Topic' id='topic' name='topic' required /></td>
	</tr>
    <tr>
    	<td colspan='2'><input type='submit' value='Next' />&nbsp;<input type='button' value='Back' onclick='Back()' /></td>
    </tr>
    </table>
    </div>
</form>
</body>
</html>
