<?php
session_start();

include_once 'scripts/authorization.php';
include_once 'scripts/save.php';
include_once '../classes/artworks.php';
include_once '../classes/images.php';
include_once '../scripts/database.php';
authorize();

$id = $_GET['id'];
// echo $removalID;
$db = $_SESSION['artwork_db'];
$sqlQuery = "UPDATE `artworks` SET `archived`=0 WHERE `id`='".$id."'";

// echo $sqlQuery;

$result = mysqli_query($db, $sqlQuery);
if ( $result ) {
   // echo $result;
    header("Location: dashboard.php");
} else {
    echo "<p>There was a problem un-archiving this piece.</p>";
    echo $sqlQuery;
}

if ($result) {
    echo $sqlQuery;
}
?>
