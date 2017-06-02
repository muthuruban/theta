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
<link rel='stylesheet' href='css/login_style.css'>
<link rel='stylesheet' href='css/main.css'>
<script type='text/javascript'>
var picker
var oid = null

function handleFileSelect()
{
	document.getElementById('progressNumber').innerHTML = '0%'
	document.getElementById('prog').value = 0
		
	var file = document.getElementById('fileToUpload').files[0]
	
	if ( file )
	{
		if ( window.FileReader )
		{
			var reader = new FileReader()
		 
			reader.onload = (function(theFile)
			{
				return function(e)
				{
					
				}
			})(file)

			reader.readAsDataURL(file)
		}
	}
}

function uploadFile()
{
	var fd = new FormData()
	fd.append('fileToUpload', document.getElementById('fileToUpload').files[0])
	
	var xhr = new XMLHttpRequest()
	xhr.upload.addEventListener ( 'progress', uploadProgress, false )
	xhr.addEventListener ( 'load', uploadComplete, false )
	xhr.addEventListener ( 'error', uploadFailed, false )
	xhr.addEventListener ( 'abort', uploadCanceled, false )
	xhr.open ( 'POST', 'ajax_processUploadResource.php' )
	xhr.send ( fd )
}

function uploadProgress ( evt )
{
	if ( evt.lengthComputable )
	{
		var percentComplete = Math.round(evt.loaded * 100 / evt.total)
		document.getElementById('progressNumber').innerHTML = percentComplete.toString() + '%'
		document.getElementById('prog').value = percentComplete
	}
	else
	{
		document.getElementById('progressNumber').innerHTML = 'Unable to compute progress!'
	}
}

function uploadComplete ( evt )
{
	/* This event is raised when the server send back a response */
	if ( evt.target.responseText.startsWith ( 'OK' ) )
	{
		oid = evt.target.responseText.substring ( 2 )

		var file = document.getElementById('fileToUpload').files[0]
		
		document.getElementById('progressNumber').innerHTML = '100%'
		document.getElementById('prog').value = 100
		
		alert ( 'Resource was uploaded successfully!' )
	}
	else if ( evt.target.responseText === 'Invalid extension' )
	{
		oid = null
	    alert ( 'Only PDF files accepted currently... please reload another file!' )
	}
	else
		alert ( evt.target.responseText )
}

function uploadFailed ( evt )
{
	alert ( 'There was an error attempting to upload the file.' )
}

function uploadCanceled ( evt )
{
	alert ( 'The upload has been canceled by the user or the browser dropped the connection.' )
}

function ReloadTable()
{
	var subjectEl = document.getElementById('subject')
	var subject = subjectEl.options [ subjectEl.selectedIndex ].value

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
			document.getElementById('spanResources').innerHTML = xmlhttp.responseText
		}
	}
	
	xmlhttp.open ( 'POST', 'ajax_performReloadResourcesTable.php', true )
	xmlhttp.setRequestHeader ( 'Content-type', 'application/x-www-form-urlencoded' )
	xmlhttp.send ( 'subject=' + subject )
}

function AddResource()
{
	var subjectEl = document.getElementById('subject')
	var subject = subjectEl.options [ subjectEl.selectedIndex ].value

	var topic = document.getElementById('topic').value
	
	if ( topic === '' )
	{
		alert ( 'Please enter topic!' )
		return
	}

	var sheetNumber = document.getElementById('sheetNumber').value
	
	if ( sheetNumber === '' )
	{
		alert ( 'Please enter sheet number!' )
		return
	}

	var title = document.getElementById('title').value
	
	if ( title === '' )
	{
		alert ( 'Please enter title!' )
		return
	}

	if ( oid === null )
	{
		alert ( 'Please upload the resource PDF file first!' )
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
				oid = null
				alert ( 'Resource added successfully!' )
				ReloadTable()
			}
			else if ( xmlhttp.responseText === 'Duplicate' )
				alert ( 'Resource already exist in database!' )
			else
				alert ( xmlhttp.responseText )
		}
	}
	
	xmlhttp.open ( 'POST', 'ajax_performAddResource.php', true )
	xmlhttp.setRequestHeader ( 'Content-type', 'application/x-www-form-urlencoded' )
	xmlhttp.send ( 'subject=' + subject + '&topic=' + topic + '&sheetNumber=' + sheetNumber + '&title=' + title + '&resourceOID=' + oid )
}

function DeleteResource ( resourceID )
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
				alert ( 'Resource deleted successfully!' )
				ReloadTable()
			}
			else if ( xmlhttp.responseText === 'Not found' )
				alert ( 'Resource not found in database!' )
			else
				alert ( xmlhttp.responseText )
		}
	}
	
	xmlhttp.open ( 'POST', 'ajax_performDeleteResource.php', true )
	xmlhttp.setRequestHeader ( 'Content-type', 'application/x-www-form-urlencoded' )
	xmlhttp.send ( 'resourceID=' + resourceID )
}
</script>
</head>
<body>
<div class='navbar'>
    <table width='100%'>
    <tr>
    	<td width='80%'><a>Resource Management</a></td>
        <td width='20%'><a href='lecturerLogout.php'>Logout</a></td>
    </tr>
    </table>
    </div>

<h2>Resource Management</h2>

<center>
<table style='width:70%'>
<tr>
    <td>Subject:</td>
    <td><select id='subject' onChange='ReloadTable()'>
    <?php
		require_once ( 'database.php' );
		
		$connection = OpenDatabase();
		
		$result = QueryDatabase ( $connection, 'SELECT "Subject Name" FROM "Subjects" ORDER BY "Subject Name" ASC' );
		
		$numSubjects = GetNumRows ( $result );
		
		$firstSubjectName = '';
		
		for ( $subjectIndex = 0; $subjectIndex < $numSubjects; ++$subjectIndex )
		{
			$subjectName = ReadField ( $result, $subjectIndex, 'Subject Name' );
			
			if ( $subjectIndex == 0 )
				$firstSubjectName = $subjectName;
			
			echo "    <option value='$subjectName'>$subjectName</option>\n";
		}
	?>
    </select></td>
</tr>
</table>
<span id='spanResources'><table id='myTable' style='width:70%'>
<tr class='header'>
	<th>Topic</th>
    <th>Sheet Number</th>
    <th>Title</th>
    <th>Action</th>
</tr>
<?php
	if ( $firstSubjectName !== '' )
	{
		$result = QueryDatabase ( $connection, 'SELECT "Resource ID","Category","Sheet Number","Title" FROM "Resources","Worksheet and Test Categories" WHERE "Worksheet and Test ID"="ID" AND "Subject"=' . "'$firstSubjectName'" . ' ORDER BY "Category" ASC,"Sheet Number" ASC,"Title" ASC' );
		
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
	}
?>
</table></span><br /><br />
<table width='50%'>
<tr>
	<td width='40%'>Topic:</td>
    <td width='60%'><input type='text' id='topic' required /></td>
</tr>
<tr>
	<td width='40%'>Sheet Number:</td>
    <td width='60%'><input type='text' id='sheetNumber' required /></td>
</tr>
<tr>
	<td width='40%'>Title:</td>
    <td width='60%'><input type='text' id='title' required /></td>
</tr>
<tr valign='top'>
	<td width='40%'>File:</td>
    <td width='60%'><input type='file' name='fileToUpload[]' id='fileToUpload' onchange='handleFileSelect()' />
    <progress id='prog' value='0' max='100.0'></progress><div id='progressNumber'></div>
    <input type='button' class='buttons' onclick='uploadFile()' value='Upload Resource' style=" width:50%" /></td>
</tr>
</table>
<input type='button' value='Add Resource' onclick='AddResource()' style='width:25%' />&nbsp;<input type='button' value='Back' onclick='location.href="lecturerMain.php"'  style='width:25%' />
</center>
</body>
</html>
