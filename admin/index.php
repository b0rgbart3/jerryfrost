<?php
session_start();
include_once '../config.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once 'scripts/dock.php';
//echo "Index<br>";
$_SESSION['logged_in'] = false;
$_SESSION['error'] = false;

$password = '';

$db = $_SESSION['artwork_db'];
if($db) {
  $dock = dock();
//    echo "has db connection.";
} else {
  $dock = "somethingelse";
//  echo "no db connnection.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $password = test_input($_POST["password"]);
}

function test_input($data) {
  //echo "Testing input";
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if (!isset($resource_path)) {
  $resource_path = "";
 }

//echo "Password: " . $password;
//echo "DOCK: " . $dock;

if ((!isset($password)) || ($password != $dock)) //"crxx33H") 
{
  $_SESSION['error'] = "wrong password";
//  echo "Wrong password.";
 //echo $password;

	header("Location: admin.php"); /* Redirect browser */
}
else
{
	$_SESSION['error'] = false;
  $_SESSION['logged_in'] = true;
  //echo $path;
  header("Location: dashboard.php?tab=collection&sort=title&order=ASC"); /* Redirect browser */
}





?>

