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

	if ( !isset ( $_GET['categoryID'] ) || !isset ( $_GET['category'] ) )
	{
		header ( 'Location:worksheetsAndTests.php?subject=' . $subject );
		die ( '' );
	}

	$categoryID = $_GET['categoryID'];
	$category = $_GET['category'];
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
			echo "<a href='worksheetsAndTests.php?subject=$subjectName'>$subjectName</a>";

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

<h2><?php echo $category; ?></h2>

<h2><?php echo $category; ?></h2>

<center>
<table style='width:70%' id='myTable'>
<tr class='header'>
    <th width='30%'>Sheet Number</th>
    <th width='70%'>Title</th>
</tr>
<?php
require_once ( 'database.php' );

$connection = OpenDatabase();

$result = QueryDatabase ( $connection, 'SELECT "Sheet Number","Title","Resource OID" FROM "Resources" WHERE "Worksheet and Test ID"=' . $categoryID . ' ORDER BY "Sheet Number" ASC' );

$numSheets = GetNumRows ( $result );

for ( $sheetIndex = 0; $sheetIndex < $numSheets; ++$sheetIndex )
{
    $sheetNumber = ReadField ( $result, $sheetIndex, 'Sheet Number' );
    $title = ReadField ( $result, $sheetIndex, 'Title' );
    //$resourceLocation = ReadField ( $result, $sheetIndex, 'Resource Location' );
    $resourceOID = ReadField ( $result, $sheetIndex, 'Resource OID' );

    echo "<tr align='center'>\n";
	echo "    <td><a href='loadResources.php?oid=$resourceOID&sheetNumber=$sheetNumber'>$sheetNumber</a></td>\n";
	echo "    <td>$title</td>\n";
	echo "</tr>\n";
}

CloseDatabase ( $connection );
?>
</table>

<input type='button' value='Back' onclick='location.href="worksheetsAndTests.php?subject=<?php echo $subject; ?>"' style='width:70%' />

</center>

</body>
</html>
