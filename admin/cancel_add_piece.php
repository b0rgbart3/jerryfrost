<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once '../classes/images.php';
session_start();
include_once '../scripts/database.php';
//echo "Checking for newImage<br>";

if ($_SESSION['newImage']) {
  //  echo "Image upload process already begun.<br>";
    // If the user is cancelling the form - but we've already saved the image
    // (which happens if they choose an image file, but then submit it with bad info)
    // then we need to delete the image that we just uploaded

    
    if ($_SESSION['newImage']->saved) {
     //   echo "Image had already been saved.<br>";
        // this method will delete it from the database AND remove the image from the uploads folder
        $_SESSION['newImage']->delete();
      //  echo "Image has now been deleted.<br>";
    } else {
       // echo "Image hadn't been saved.<br>";
        // if the image was uploaded without saving it to the db then we just need to remove the stray file
        unlink("../uploads/artwork/".$_SESSION['newImage']->image_filename);
      //  echo "Image was just removed.";
    }
    



}
//echo "About to redirect.<br>";
// redirect to the main dashboard
header("Location: dashboard.php");

//echo "Tried to redirect.<br>";
?>

