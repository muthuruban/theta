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
	echo ( $subject === 'Theta' ) ? "<a>Theta</a>" : "<a href='worksheetsAndTests.php?subject=Theta'>Theta</a>";
	echo "</td>\n";

	echo "<td width='10%'>";
	echo ( $subject === 'Maths' ) ? "<a>Maths</a>" : "<a href='worksheetsAndTests.php?subject=Maths'>Maths</a>";
	echo "</td>\n";

	echo "<td width='20%'>";
	echo ( $subject === 'Programming' ) ? "<a>Programming Support</a>" : "<a href='worksheetsAndTests.php?subject=Programming'>Programming Support</a>";
	echo "</td>\n";
?>
	<td width='20%'>&nbsp;</td>
	<td width='20%'><a href='viewAppointments.php'>View Appointments</a></td>
    <td width='20%'><a href='logout.php'>Logout</a></td>
</tr>
</table>
</div>

<h2><?php echo $subject; ?> Worksheets and Tests</h2>

<h2><?php echo $subject; ?> Worksheets and Tests</h2>

<center>
<table width='70%'>
<?php
require_once ( 'database.php' );

$connection = OpenDatabase();

$result = QueryDatabase ( $connection, 'SELECT "ID","Category","Category Image" FROM "Worksheet and Test Categories" WHERE "Subject"=' . "'$subject' ORDER BY \"Category\" ASC" );

$numCategories = GetNumRows ( $result );

for ( $categoryIndex = 0; $categoryIndex < $numCategories; ++$categoryIndex )
{
	$id = ReadField ( $result, $categoryIndex, 'ID' );
    $category = ReadField ( $result, $categoryIndex, 'Category' );
    $categoryImage = ReadField ( $result, $categoryIndex, 'Category Image' );

    if ( $categoryIndex % 3 == 0 ) echo "<tr>\n";
    echo "    <td width='33.3%' align='center'><a href='resources.php?subject=$subject&categoryID=$id&category=$category'><img src='$categoryImage' /><br /><h3>$category\n</h3></a></td>\n";
    if ( $categoryIndex % 3 == 2 ) echo "</tr>\n";
}

for ( $categoryIndex = 0; $categoryIndex < ( 3 - ( $numCategories % 3 ) ) % 3; ++$categoryIndex )
    echo "<td width='33.3%'>&nbsp;</td>\n";

CloseDatabase ( $connection );
?>
</table>

<input type='button' value='Back' onclick='location.href="main.php?subject=<?php echo $subject; ?>"' style='width:70%' />

</center>

</body>
</html>
