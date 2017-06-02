<?php
	session_start();

	if ( !isset ( $_SESSION['username'] ) || !isset ( $_SESSION['name'] ) )
	{
		header ( 'Location:index.html' );
		die ( '' );
	}

	$studentUsername = $_SESSION['username'];

	if ( !isset ( $_POST['subject'] ) )
	{
		header ( 'Location:main.php' );
		die ( '' );
	}

	$subject = $_POST['subject'];

	if ( !isset ( $_POST['advisor'] ) )
	{
		header ( "Location:scheduleOneToOneAppointments.php?subject=$subject" );
		die ( '' );
	}

	$advisor = $_POST['advisor'];

	if ( !isset ( $_POST['date'] ) )
	{
		header ( 'Location:main.php' );
		die ( '' );
	}

	$date = $_POST['date'];

	if ( !isset ( $_POST['time'] ) )
	{
		header ( 'Location:main.php' );
		die ( '' );
	}

	$time = $_POST['time'];

	if ( !isset ( $_POST['contactNumber'] ) )
	{
		header ( 'Location:main.php' );
		die ( '' );
	}

	$contactNumber = $_POST['contactNumber'];

	if ( !isset ( $_POST['contactEmail'] ) )
	{
		header ( 'Location:main.php' );
		die ( '' );
	}

	$contactEmail = $_POST['contactEmail'];

	if ( !isset ( $_POST['universityNumber'] ) )
	{
		header ( 'Location:main.php' );
		die ( '' );
	}

	$universityNumber = $_POST['universityNumber'];

	if ( !isset ( $_POST['numberOfAttendees'] ) )
	{
		header ( 'Location:main.php' );
		die ( '' );
	}

	$numberOfAttendees = $_POST['numberOfAttendees'];

	if ( !isset ( $_POST['degreeCourseName'] ) )
	{
		header ( 'Location:main.php' );
		die ( '' );
	}

	$degreeCourseName = $_POST['degreeCourseName'];

	if ( !isset ( $_POST['qualificationStudiedFor'] ) )
	{
		header ( 'Location:main.php' );
		die ( '' );
	}

	$qualificationStudiedFor = $_POST['qualificationStudiedFor'];

	if ( !isset ( $_POST['yearOfStudy'] ) )
	{
		header ( 'Location:main.php' );
		die ( '' );
	}

	$yearOfStudy = $_POST['yearOfStudy'];

	if ( !isset ( $_POST['topic'] ) )
	{
		header ( 'Location:main.php' );
		die ( '' );
	}

	$topic = $_POST['topic'];
	
	require_once ( 'database.php' );
	
	$connection = OpenDatabase();

	$sql = 'INSERT INTO "Scheduled Appointments" ("Advisor","Date","Time","Subject","Student","Contact Number","Contact E-mail","University Number","Number of Attendees","Degree Course Name","Qualifications Studied For","Year of Study","Topic") VALUES';
	$sql = "$sql ('$advisor','$date','$time','$subject','$studentUsername','$contactNumber','$contactEmail','$universityNumber',$numberOfAttendees,'$degreeCourseName','$qualificationStudiedFor',$yearOfStudy,'$topic')";
	
	QueryDatabase ( $connection, $sql );
	
	CloseDatabase ( $connection );
?>
<!DOCTYPE html>
<html>
<head>
<link rel='stylesheet' href='css/main.css'>
<title>Study Support Services</title>
</head>

<body>
<br /><br />
<center>
		<h2><font color='red'>Schedule Appointment Success</font></h3><br /><br />
		<h3>Your appointment has been booked successfully!<br /><br />
		Please be on time for the appointment!</h3><br /><br />
        <input type='button' value='OK' onclick='location.href="main.php"' />
		</center>
</body>
</html>