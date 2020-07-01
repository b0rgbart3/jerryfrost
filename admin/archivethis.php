<?php
session_start();

include_once 'scripts/authorization.php';
include_once 'scripts/save.php';
include_once '../classes/artworks.php';
include_once '../classes/images.php';
include_once '../scripts/database.php';
authorize();

$removalID = $_GET['id'];
// echo $removalID;
$db = $_SESSION['artwork_db'];
$sqlQuery = "UPDATE `artworks` SET `archived`=1 WHERE `id`=".$removalID;

$result = mysqli_query($db, $sqlQuery);
if ( $result ) {
    $refer = $_SERVER['HTTP_REFERER'];
    echo $refer;
    header("Location: ".$refer);
} else {
    echo "<p>There was a problem archiving this piece.</p>";
}


?>
