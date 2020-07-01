<?php
session_start();
include_once '../../classes/artworks.php';
include_once '../../classes/images.php';
include_once '../../scripts/database.php';

$db = $_SESSION['artwork_db'];

    if($db) {
  
        $artwork = new artworks(['','','','','','','','','']);
        $result = null;
        $sqlString = $artwork->definition;
        echo $sqlString;
        $result = mysqli_query($db, $sqlString);

        if ($result) {
            echo "<br>Successfully creted the artworks table";
        } else {
        die("<p>Error in creating the artworks table. </p>");
        }
    }



?>