<?php

  function findWork($id) {
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

    $work = findWork($id);
    $image = $work->images[0]->image_filename;

  }


?>


<div class='artContainer group'>
<div class='swiper group' id='swiper'></div>
<div class='art_slider group' id='art_slider'>
    <div class='slide c1 group'><img id='centralImage' src='uploads/artwork/<?php 
    echo $image; ?>'></div>
    </div>
    <div class='prev'></div>


    <div class='next'></div>


    <div class='titleTag'>
    <div class='tt_title'><?php echo $work->title; ?></div>
    <div class='tt_date'><?php echo $work->humanReadableCreatedDate(); ?></div>
        <div class='tt_size'>
        </div>   
        <div class='tt_sold'></div>
</div>

<script src='js/config.js'></script>
<script src='js/mobile.js'></script>
<script src='js/slide_setup.js'></script>
<script src='js/move.js'></script>
<script src='js/sizer.js'></script>
<script src='js/slider.js'></script>

</div>

<?php
// I am outputting a hidden div - as a way to pass my data to JS
// because PHP has a 4k Buffer - so I need to send it as HTML and then
// use JS to convert it to a JSON object.  Instead of outputting
// a JS variable declaration.   Stupid and annoying, yes.

echo "<div class='hiddenImages'>";

foreach($works as $work) {
  if ($category == 'current') {
    if ($work->isCurrent()) {
      echo "<div id='".$work->id."' data-id=".$work->id." data-title='".$work->title."' data-created='".
    $work->humanReadableCreatedDate()."' data-width='".$work->width."'data-height='".$work->height."' data-sold=".$work->sold." data-archived=".$work->archived." data-source= '". $work->images[0]->image_filename."' class='work'></div>";
    }
  }
  else {
  if ($work->category == $category) {
    echo "<div id='".$work->id."' data-id=".$work->id." data-title='".$work->title."' data-created='".
    $work->humanReadableCreatedDate()."' data-width='".$work->width."'data-height='".$work->height."' data-sold=".$work->sold." data-archived=".$work->archived." data-source= '". $work->images[0]->image_filename."' class='work'></div>";
    }
  }
}
 echo "</div>"; 
?>

</div>