<?php

session_start();

$extra_files = $_SESSION['offending_file_array'];

foreach($extra_files as $file) {
   //echo $file."<br>";
   unlink($file);
}
header("Location: dashboard.php");

?>
