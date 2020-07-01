<?php
session_start();
$error = false;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $archive = test_input($_POST["archive"]);
  $honeypot = test_input($_POST["honeypot"]);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if ($honeypot != "")
{
	$error = true;
}

if ($archive == "")
{
	$error = true;
}




//  Here we want to take the item in question ($archive) and move it's data into the archive
// thereby removing it from the active collection.





      //  header("Location: ../contact.php"); /* Redirect browser */


?>

