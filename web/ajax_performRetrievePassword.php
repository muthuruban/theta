<?php
$username = $_POST['username'];

require_once ( 'database.php' );

$connection = OpenDatabase();

$result = QueryDatabase ( $connection, 'SELECT "E-mail","Name","Password" FROM "Student Profile" WHERE "Username"=' . "'$username'" );

if ( GetNumRows ( $result ) != 1 )
{
	CloseDatabase ( $connection );
	die ( 'Not found' );
}

$email = ReadField ( $result, 0, 'E-mail' );
$name = ReadField ( $result, 0, 'Name' );
$password = ReadField ( $result, 0, 'Password' );

CloseDatabase ( $connection );

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set ( 'Etc/UTC' );

require 'phpmailer/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;

//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;

//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = 'theta.app.2017@gmail.com';

//Password to use for SMTP authentication
$mail->Password = 'thetaapp2017';

//Set who the message is to be sent from
$mail->setFrom ( 'theta.app.2017@gmail.com', 'Study Support Services Administrator' );

//Set an alternative reply-to address
$mail->addReplyTo ( 'theta.app.2017@gmail.com', 'Study Support Services Administrator' );

//Set who the message is to be sent to
$mail->addAddress ( $email, $name );

//Set the subject line
$mail->Subject = 'Your Study Support Services Password';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML ( "Dear $name,<br /><br />We have received your request to reset your password.<br /><br />Your Study Support Services Password is <b>$password</b>.<br /><br />Best regards,<br />Study Support Services Administrator" );

//Replace the plain text body with one created manually
$mail->AltBody = "Dear $name,\n\nWe have received your request to reset your password.\n\nYour Study Support Services Password is $password.\n\nBest regards,\nStudy Support Services Administrator";

//send the message, check for errors
if ( !$mail->send() )
{
    die ( 'Mailer Error: ' . $mail->ErrorInfo );
}
else
{
    die ( 'OK' );
}
?>
