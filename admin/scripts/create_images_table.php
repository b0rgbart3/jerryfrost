<?php
session_start();
include_once '../../classes/images.php';
include_once '../../scripts/database.php';

$db = $_SESSION['artwork_db'];

    if($db) {
  
        $image = new images(['','','','','']);
        $result = null;
        $sqlString = $image->definition;
        //echo $sqlString;
        $result = mysqli_query($db, $sqlString);

        if ($result) {
            echo "<br>Successfully creted the images table";
        } else {
        die("<p>Error in creating the images table. </p>");
        }
    }



?>