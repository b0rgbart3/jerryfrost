<?php
session_start();
include_once '../../classes/shows.php';
// include_once '../../classes/artworks.php';
// include_once '../../classes/images.php';
include_once '../../scripts/database.php';

$db = $_SESSION['artwork_db'];

    if($db) {
  
        $show = new shows(['']);
        $result = null;
        $sqlString = $show->definition;
        echo $sqlString;
        $result = mysqli_query($db, $sqlString);

        if ($result) {
            echo "<br>Successfully creted the shows table";
        } else {
        die("<p>Error in creating the shows table. </p>");
        }
    }



?>