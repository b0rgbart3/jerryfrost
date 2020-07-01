<?php

function findThisWork($id) {
    $works = $_SESSION["works"];
    $foundwork = null;
    foreach($works as $work) {
      if ($work->id == $id) {
          $foundwork = $work;
      }
    }
    return $foundwork;
}
if ($id !=0 ) {

  $work = findThisWork($id);
  $image = $work->images[0]->image_filename;

}

echo '<meta property="og:image" content="http://jerryfrost.com/uploads/artwork/'.$image.'">';
echo '<meta property="og:url" content="http://jerryfrost.com/uploads/artwork/'.$image.'">';
?>

