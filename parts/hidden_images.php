<?php
/* This loads all the images into a hidden div -- as a preloader for the rest of the site */

if (isset($works)) {
    echo "<div class='hiddenImages'>";
    foreach($works as $work) {
        // If there's no image uploaded, then let's not even include 
        if (isset($work->images[0]) ) {
      
        echo "<img src='uploads/artwork/". $work->images[0]->image_filename. "'>";
 
       }
       
    }echo "</div>";
}
?>


