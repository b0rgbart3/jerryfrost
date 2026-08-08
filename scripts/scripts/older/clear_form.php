<?php
session_start();

/*  This script is designed to clear out all the form data -- effectively canceling the contact form.
*/

$error = false;

$_SESSION['name'] = "";
$_SESSION['email'] = "";
$_SESSION['user_message'] = "";
$_SESSION['attempted'] = false;
$_SESSION['email_sent'] = false;
$_SESSION['error'] = "";

header("Location: ../index.php"); /* Redirect browser */
# asdfasdf


?>

