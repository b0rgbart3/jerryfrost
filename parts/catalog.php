<?php

?>
<script src='js/config.js'></script>
<script src='js/catalog.js'></script>

<div class='catalogNav'>
<div class='catalogNavItem' data-target='current'>Current
    </div>
    <div class='catalogNavItem' data-target='social'>Social Commentary
    </div>
    <div class='catalogNavItem' data-target='abstract'>Abstract
    </div>

    <div class='catalogNavItem' data-target='figurative'>Figurative
    </div><div class='catalogNavItem' data-target='landscape'>Landscapes
    </div>
</div>     

<div id='info'>
<?php 
$works = $_SESSION['works'];
//echo "Number of paintings in this cateogry: ". count($works)."<br>";
?>
</div>
<div class='thumbContainer group'>

</div>
</div>

<?php 



// This just outputs our entire $works array - so that we can convert it to a JSON object

echo "<div class='works'>";
//echo "This is a normal english sentence.";
foreach($works as $workIndex => $work) {
    echo "<div class='workData' data-id=".$work->id." data-image_filename='". $work->images[0]->image_filename. "' data-title='".
    $work->title."' data-category='".$work->category."' data-date='".$work->created."' data-simple_date='".$work->simpleDate()."' data-sold='".$work->sold."' data-width='".$work->width."' data-height='".$work->height."'></div>";
    
}
echo "</div>";

?>