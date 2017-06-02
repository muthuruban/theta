<table id='myTable' style='width:70%'>
<tr class='header'>
	<th>Topic</th>
    <th>Sheet Number</th>
    <th>Title</th>
    <th>Action</th>
</tr>
<?php
	$subject = $_POST['subject'];

	require_once ( 'database.php' );
	
	$connection = OpenDatabase();

	$result = QueryDatabase ( $connection, 'SELECT "Resource ID","Category","Sheet Number","Title" FROM "Resources","Worksheet and Test Categories" WHERE "Worksheet and Test ID"="ID" AND "Subject"=' . "'$subject'" . ' ORDER BY "Category" ASC,"Sheet Number" ASC,"Title" ASC' );
	
	$numItems = GetNumRows ( $result );
	
	for ( $itemIndex = 0; $itemIndex < $numItems; ++$itemIndex )
	{
		$resourceID = ReadField ( $result, $itemIndex, 'Resource ID' );
		$topic = ReadField ( $result, $itemIndex, 'Category' );
		$sheetNumber = ReadField ( $result, $itemIndex, 'Sheet Number' );
		$title = ReadField ( $result, $itemIndex, 'Title' );
		
		echo "<tr>\n";
		echo "    <td>$topic</td>\n";
		echo "    <td>$sheetNumber</td>\n";
		echo "    <td>$title</td>\n";
		echo "    <td><input type='button' value='Delete' onclick='DeleteResource($resourceID)' /></td>\n";
		echo "</tr>\n";
	}
	
	CloseDatabase ( $connection );
?>
</table>