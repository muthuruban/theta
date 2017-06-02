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
<script type='text/javascript'>
function AddSubject()
{
	var subject = document.getElementById('subject').value
	
	if ( subject === '' )
	{
		alert ( 'Please enter name of subject!' )
		return
	}
	
	var xmlhttp

	if ( window.XMLHttpRequest )
		xmlhttp = new XMLHttpRequest()
	else
	{
		// code for IE6, IE5
		xmlhttp = new ActiveXObject ( 'Microsoft.XMLHTTP' )
	}
	
	xmlhttp.onreadystatechange = function()
	{
		if ( this.readyState == 4 && this.status == 200 )
		{
			if ( xmlhttp.responseText === 'OK' )
			{
				alert ( 'Subject added successfully!' )
				location.reload ( true )
			}
			else if ( xmlhttp.responseText === 'Duplicate' )
				alert ( 'Subject already exist in database!' )
			else
				alert ( xmlhttp.responseText )
		}
	}
	
	xmlhttp.open ( 'POST', 'ajax_performAddSubject.php', true )
	xmlhttp.setRequestHeader ( 'Content-type', 'application/x-www-form-urlencoded' )
	xmlhttp.send ( 'subject=' + subject )
}

function DeleteSubject ( subject )
{
	var xmlhttp

	if ( window.XMLHttpRequest )
		xmlhttp = new XMLHttpRequest()
	else
	{
		// code for IE6, IE5
		xmlhttp = new ActiveXObject ( 'Microsoft.XMLHTTP' )
	}
	
	xmlhttp.onreadystatechange = function()
	{
		if ( this.readyState == 4 && this.status == 200 )
		{
			if ( xmlhttp.responseText === 'OK' )
			{
				alert ( 'Subject deleted successfully!' )
				location.reload ( true )
			}
			else if ( xmlhttp.responseText === 'Not found' )
				alert ( 'Subject not found in database!' )
			else
				alert ( xmlhttp.responseText )
		}
	}
	
	xmlhttp.open ( 'POST', 'ajax_performDeleteSubject.php', true )
	xmlhttp.setRequestHeader ( 'Content-type', 'application/x-www-form-urlencoded' )
	xmlhttp.send ( 'subject=' + subject )
}
</script>
</head>
<body>
<div class='navbar'>
    <table width='100%'>
    <tr>
    	<td width='80%'><a>Subject Management</a></td>
        <td width='20%'><a href='lecturerLogout.php'>Logout</a></td>
    </tr>
    </table>
    </div>

<h2>Subject Management</h2>

<center>
<table id='myTable' style='width:50%'>
<tr class='header'>
    <th>Subjects</th>
    <th>Action</th>
</tr>
<?php
	require_once ( 'database.php' );
	
	$connection = OpenDatabase();
	
	$result = QueryDatabase ( $connection, 'SELECT "Subject Name" FROM "Subjects" ORDER BY "Subject Name" ASC' );
	
	$numSubjects = GetNumRows ( $result );
	
	for ( $subjectIndex = 0; $subjectIndex < $numSubjects; ++$subjectIndex )
	{
		$subjectName = ReadField ( $result, $subjectIndex, 'Subject Name' );
		
		echo "<tr>\n";
		echo "    <td>$subjectName</td>\n";
		echo "    <td><input type='button' value='Delete' onclick='DeleteSubject(\"$subjectName\")' /></td>\n";
		echo "</tr>\n";
	}
	
	CloseDatabase ( $connection );
?>
</table><br /><br />
<table width='30%'>
<tr>
	<td width='40%'>Subject:</td>
    <td width='60%'><input type='text' id='subject' required /></td>
</tr>
</table>
<input type='button' value='Add Subject' onclick='AddSubject()' style='width:25%' />&nbsp;<input type='button' value='Back' onclick='location.href="lecturerMain.php"'  style='width:25%' />
</center>
</body>
</html>
