<?php
require_once "scripts/in_memory_functions.php"; 

$mostCurrentId = get_most_current_id();
?>

<div class='navigation group'>
        <ul class='group'>
        <?php if (!isset($page) || $page!='home') {
                echo "<li data-destination='home' class='hot'>Home</li>";
            } ?>
        <li data-destination='current' data-id='<?php echo $mostCurrentId; ?>'
         class='hot'>The Gallery</li>
            <!-- <li data-destination='current' class='hot'>Current</li>
            <li data-destination='social' class='hot'>Social</li>
            <li data-destination='abstract' class='hot'>Abstract</li>
            <li data-destination='figurative' class='hot'>Figurative</li>
            <li data-destination='landscapes' class='hot'>Landscapes</li> -->
    

            <li data-destination='catalog' class='hot'>The Catalog</li> 
            <li data-destination='shows' class='hot'>Upcoming Shows</li> 
            <li data-destination='bio' class='hot'>Biography</li>     
            <li data-destination='contact' class='hot'>Contact Jerry</li>       
        </ul>
</div>

</div> 
<!-- end of completeTitle group -->