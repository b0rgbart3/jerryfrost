<?php
session_start();

include_once 'scripts/authorization.php';
include_once 'scripts/save.php';
include_once '../classes/artworks.php';
include_once '../classes/images.php';
include_once '../scripts/database.php';
authorize();

$removalID = null;
if (isset($_GET['id'])) {
$removalID = $_GET['id'];
}

$tab = null;
if (isset($_GET['tab'])) {
    $tab = $_GET['tab'];
}
// echo $removalID;


$db = $_SESSION['artwork_db'];

// first - find the associated image - and then we can delete the uploaded file,
// then delete the image, and finally delete the artwork

$sqlQuery = "SELECT * FROM `images` WHERE `artwork_id` = '".$removalID."';";
$result = mysqli_query($db, $sqlQuery);

$data = [];
if ($result) {
    while ($row = mysqli_fetch_row($result)) {
            array_push($data, $row);
    }
}
// echo "data: <br>";
// print_r($data[0]);

if ($data && $data[0] && ( sizeof($data[0]) > 2) ) {
    $filename = $data[0][2];
    $path = "../uploads/artwork/".$filename;
   // echo 'about to unlink file: ' . $path;
    unlink($path);
    $path = "../uploads/thumbs/".$filename;
    // echo 'about to unlink file: ' . $path;
     unlink($path);
}


$sqlQuery = "DELETE FROM `images` WHERE `artwork_id` = ".$removalID;
$result = mysqli_query($db, $sqlQuery);
if ( !$result ) {

    echo "<p>There was a problem removing the image from the database.</p>";
}
 else {

        $sqlQuery = "DELETE FROM `artworks` WHERE `artworks`.`id` = ".$removalID;

        $result = mysqli_query($db, $sqlQuery);
        if ( $result ) {
            $refer = $_SERVER['HTTP_REFERER'];
            //echo $refer;
            header("Location: ".$refer);
            // if (isset($tab)){
            //     header("Location: dashboard.php"."?tab=".$tab);
            // } else {
            // header("Location: dashboard.php");}
        } else {
            echo "<p>There was a problem removing this piece from the database.</p>";
        }
 }

?>
