<?php
//phpinfo();
// for some reason this class definition needs to get loaded in before the
// session start call ??
require '../classes/artworks.php';
//require '../classes/images.php';
session_start();
include_once 'scripts/authorization.php';
include_once 'scripts/save.php';
include_once '../scripts/in_memory_functions.php';
authorize();
include_once 'head.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
   // $artwork = findArtwork($id);

  //  if (isset($_GET['image'])) {
    //    $imageID = $_GET['image'];
        //echo "About to remove image: ".$imageID;

        $db = $_SESSION['artwork_db'];
        $success = removeimage($id,$db);
        if ($success) {
            header("Location: dashboard.php");
        }
   // }

    
}


