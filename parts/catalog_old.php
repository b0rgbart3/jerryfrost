<?php

function collectCurrentWorks() {
    $possible = $_SESSION['works'];
    $collected = [];
    foreach($possible as $work) {
        if ($work->isCurrent()) {
            array_push($collected,$work);
        }
    }
    return $collected;
}
function collectWorks($category) {
    $possible = $_SESSION['works'];
    $collected = [];
    foreach($possible as $work) {
        if ($work->category == $category) {
      
           if($work->images[0]->image_filename != '') {
        
              array_push($collected,$work);
           }
        }
    }
    return $collected;
}
// This displays the FULL CATALOG
$categories = [ 'social','abstract', 'figurative', 'landscape'];

echo "<div class='catalogContainer group'>";
echo "<div class='catalog'>";
// $_SESSION['ordered_by'] = 'created';
// $category = 'current';
// $works = load_art_with_images($db,$category, false);
// outputSection($works,$category);

$works = collectCurrentWorks();
outputSection($works,'current');

foreach($categories as $category) {
 //   $works = load_art_with_images($db, $category, false);

 $works = collectWorks($category);

    outputSection($works,$category);
   
 
}


      
function outputSection($works,$category) {
    if (sizeof($works) >0) {
        echo "<a name='".$category."'></a>";
        echo "<div class='catalogSectionContainer group'>";
        echo "<div class='catalogSection group' id='".$category."'>" . $category."</div>";
   
        foreach($works as $workIndex => $work) {
            
            $image = findImage($work->id);
            $linkIndex = $workIndex;
           // if ($image && $image->image_filename !='') {
                echo "<div class='catalogframe'><div class='catalogimagecontainer'>";

                
                 echo "<a href='art.php?category=".$category."&piece=".$linkIndex."'>";
                // echo "<a href='art.php?category=".$category."&piece=0'>";
                echo "<img src='uploads/artwork/". $image->image_filename. "' class='catalogImage'></a>";
                
                echo "</div>";
                echo "<div class='artworkBrass'>";
                echo "<p class='title'>".$work->title."</p>";
                echo "<p class='date'>". $work->simpleDate()."</p>";
                echo "<p class='size'>";
                echo $work->width." X ";
                echo $work->height;
                
                if ($work->sold) { echo "<span class='soldSPan'></span>"; } 
                echo "</p>";
                echo "</div></div>";
                }
        
      //  } 
    }

    echo "</div><br><br>";
}
echo "</div><br>";
?>
    <script src='js/catalog.js'></script>


<div class='catalogNav'>
<div class='catalogNavItem' data-target='current'>Current
    </div>
    <div class='catalogNavItem' data-target='social'>Social
    </div>
    <div class='catalogNavItem' data-target='abstract'>Abstract
    </div>

    <div class='catalogNavItem' data-target='figurative'>Figurative
    </div><div class='catalogNavItem' data-target='landscape'>Landscape
    </div>
</div>         
</div>
