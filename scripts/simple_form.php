<?php
	session_start();


$name=$_REQUEST['name']; 
$email=$_REQUEST['email']; 
$message=$_REQUEST['message']; 
$contact_attempted = true;

$_SESSION['name'] = $name;
$_SESSION['email'] = $email;
$_SESSION['message'] = $message;
$_SESSION['contact_attempted'] = true;
$_SESSION['email_sent'] = false;

?>

<html>
<body>
	Simple Form.
	</body>
</html>

