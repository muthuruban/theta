<?php
	session_start();

	if ( !isset ( $_SESSION['username'] ) || !isset ( $_SESSION['name'] ) )
	{
		header ( 'Location:index.html' );
		die ( '' );
	}

	if ( !isset ( $_POST['subject'] ) )
	{
		header ( 'Location:main.php' );
		die ( '' );
	}

	$subject = $_POST['subject'];

	if ( !isset ( $_POST['supportID'] ) )
	{
		header ( 'Location:scheduleOneToOneAppointments.php?subject=' . $subject );
		die ( '' );
	}

	$supportID = $_POST['supportID'];

	if ( !isset ( $_POST['hour'] ) )
	{
		header ( "Location:scheduleAppointmentTime.php?subject=$subject&supportID=$supportID" );
		die ( '' );
	}

	$hour = $_POST['hour'];

	if ( !isset ( $_POST['contactNumber'] ) )
	{
		header ( "Location:scheduleAppointmentDetails.php?subject=$subject&supportID=$supportID&hour=$hour" );
		die ( '' );
	}

	$contactNumber = $_POST['contactNumber'];

	if ( !isset ( $_POST['contactEmail'] ) )
	{
		header ( "Location:scheduleAppointmentDetails.php?subject=$subject&supportID=$supportID&hour=$hour" );
		die ( '' );
	}

	$contactEmail = $_POST['contactEmail'];

	if ( !isset ( $_POST['universityNumber'] ) )
	{
		header ( "Location:scheduleAppointmentDetails.php?subject=$subject&supportID=$supportID&hour=$hour" );
		die ( '' );
	}

	$universityNumber = $_POST['universityNumber'];

	if ( !isset ( $_POST['numberOfAttendees'] ) )
	{
		header ( "Location:scheduleAppointmentDetails.php?subject=$subject&supportID=$supportID&hour=$hour" );
		die ( '' );
	}

	$numberOfAttendees = $_POST['numberOfAttendees'];

	if ( !isset ( $_POST['degreeCourseName'] ) )
	{
		header ( "Location:scheduleAppointmentDetails.php?subject=$subject&supportID=$supportID&hour=$hour" );
		die ( '' );
	}

	$degreeCourseName = $_POST['degreeCourseName'];

	if ( !isset ( $_POST['qualificationStudiedFor'] ) )
	{
		header ( "Location:scheduleAppointmentDetails.php?subject=$subject&supportID=$supportID&hour=$hour" );
		die ( '' );
	}

	$qualificationStudiedFor = $_POST['qualificationStudiedFor'];

	if ( !isset ( $_POST['yearOfStudy'] ) )
	{
		header ( "Location:scheduleAppointmentDetails.php?subject=$subject&supportID=$supportID&hour=$hour" );
		die ( '' );
	}

	$yearOfStudy = $_POST['yearOfStudy'];

	if ( !isset ( $_POST['topic'] ) )
	{
		header ( "Location:scheduleAppointmentDetails.php?subject=$subject&supportID=$supportID&hour=$hour" );
		die ( '' );
	}

	$topic = $_POST['topic'];
	
	require_once ( 'database.php' );
	
	$connection = OpenDatabase();
	
	$result = QueryDatabase ( $connection, 'SELECT "Lecturer Username","Name","Day" FROM "General Support Staffing","Lecturer Profile" WHERE "Lecturer Username"="Username" AND "ID"=' . $supportID );
	
	$lecturerUsername = ReadField ( $result, 0, 'Lecturer Username' );
	$lecturerName = ReadField ( $result, 0, 'Name' );
	$day = ReadField ( $result, 0, 'Day' );
	
	$result = QueryDatabase ( $connection, 'SELECT to_char("a",\'FMDay, FMDDth FMMonth YYYY\') AS "Schedule Date" FROM generate_series (current_date + \'1 day\'::interval, current_date + \'7 days\'::interval, \'1 day\') AS s(a) WHERE to_char(a,\'FMDay\')=' . "'$day'" );

	$scheduleDate = ReadField ( $result, 0, 'Schedule Date' );
	
	CloseDatabase ( $connection );
?>
<!DOCTYPE html>
<html>
<head>
<title>Study Support Services</title>
<script type='text/javascript'>
function Back()
{
	location.href = 'scheduleAppointmentDetails.php?subject=<?php echo $subject; ?>&supportID=<?php echo $supportID; ?>&hour=<?php echo $hour; ?>'
}
</script>
</head>
<body>
<link rel='stylesheet' href='css/login_style.css'>
<link rel='stylesheet' href='css/main.css'>
<h1>Schedule Verification</h1>
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

<h2>Schedule Verification</h2>

<div class='container'>
    <form method='POST' action='scheduleBook.php'>
    <table width='90%'>
    <tr>
        <td width='40%'><label><b>Advisor</b></label></td>
        <td width='60%'><label><?php echo $lecturerName; ?></label></td>
    </tr>
    <tr>
        <td><label><b>Date</b></label></td>
        <td><label><?php echo $scheduleDate; ?></label></td>
    </tr>
    <tr>
        <td><label><b>Time</b></label></td>
        <td><label><?php echo ( $hour < 10 ) ? "0$hour:00" : "$hour:00"; ?></label></td>
    </tr>
    <tr>
        <td><label><b>Contact Number</b></label></td>
        <td><label><?php echo $contactNumber; ?></label></td>
    </tr>
    <tr>
        <td><label><b>Contact E-mail</b></label></td>
        <td><label><?php echo $contactEmail; ?></label></td>
    </tr>
    <tr>
        <td><label><b>University Number<br />(if applicable)</b></label></td>
        <td><label><?php echo $universityNumber; ?></label></td>
    </tr>
    <tr>
        <td><label><b>Number of Attendees</b></label></td>
        <td><label><?php echo $numberOfAttendees; ?></label></td>
    </tr>
    <tr>
        <td><label><b>Degree Course Name</b></label></td>
        <td><label><?php echo $degreeCourseName; ?></label></td>
    </tr>
    <tr>
        <td><label><b>Qualification Studied For</b></label></td>
        <td><label><?php echo $qualificationStudiedFor; ?></label></td>
    </tr>
    <tr>
        <td><label><b>Year of Study</b></label></td>
        <td><label><?php echo $yearOfStudy; ?></label></td>
    </tr>
    <tr>
        <td><label><b>Topic</b></label></td>
        <td><label><?php echo $topic; ?></label></td>
    </tr>
    <tr>
        <td colspan='2'><input type='submit' value='Make Appointment' />&nbsp;<input type='button' value='Back' onclick='history.go(-1)' /></td>
    </tr>
    </table>
    <input type='hidden' name='subject' value='<?php echo $subject; ?>' />
    <input type='hidden' name='advisor' value='<?php echo $lecturerUsername; ?>' />
    <input type='hidden' name='date' value='<?php echo $scheduleDate; ?>' />
    <input type='hidden' name='time' value='<?php echo ( $hour < 10 ) ? "0$hour:00" : "$hour:00"; ?>' />
    <input type='hidden' name='contactNumber' value='<?php echo $contactNumber; ?>' />
    <input type='hidden' name='contactEmail' value='<?php echo $contactEmail; ?>' />
    <input type='hidden' name='universityNumber' value='<?php echo $universityNumber; ?>' />
    <input type='hidden' name='numberOfAttendees' value='<?php echo $numberOfAttendees; ?>' />
    <input type='hidden' name='degreeCourseName' value='<?php echo $degreeCourseName; ?>' />
    <input type='hidden' name='qualificationStudiedFor' value='<?php echo $qualificationStudiedFor; ?>' />
    <input type='hidden' name='yearOfStudy' value='<?php echo $yearOfStudy; ?>' />
    <input type='hidden' name='topic' value='<?php echo $topic; ?>' />
    </form>
</div>
</body>
</html>
