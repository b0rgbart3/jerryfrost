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

// first - find the associated image - and then we can delete the uploaded file,
// then delete show

$sqlQuery = "SELECT * FROM `shows` WHERE `id` = '".$removalID."';";
$result = mysqli_query($db, $sqlQuery);

$data = [];
if ($result) {
    while ($row = mysqli_fetch_row($result)) {
            array_push($data, $row);
    }
}
 //echo "data: <br>";
 //print_r($data[0]);

if ($data[0] && $data[0][12]) {
    $filename = $data[0][12];
    $path = "../uploads/show_images/".$filename;
    echo 'about to unlink file: ' . $path;
    unlink($path);
}


$sqlQuery = "DELETE FROM `shows` WHERE `id` = ".$removalID;
$result = mysqli_query($db, $sqlQuery);
if ( !$result ) {

    echo "<p>There was a problem removing the show from the database.</p>";
}
 else {

        $sqlQuery = "DELETE FROM `shows` WHERE `id` = ".$removalID;

        $result = mysqli_query($db, $sqlQuery);
        if ( $result ) {
         //   header("Location: dashboard.php");
        } else {
            echo "<p>There was a problem removing this show from the database.</p>";
        }
 }

 header("Location: dashboard.php");

?>
