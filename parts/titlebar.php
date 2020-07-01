<?php ?>
    <!-- This div ends after the navigation block -->
<div class='completeTitle group'>  
<div class='titleFramer group'>
<div class='titleBox group'>
<?php if (isset($page) && $page == 'home') { ?>
    <div class='titleText group'>

<h1>Jerry Frost</h1>
<h2>artist</h2>

</div>
<?php
} else {
    ?>
    <div class='titleTextBack hot group' data-destination='home'>
        <div class='titleTextContainer'>
<h1>Jerry Frost</h1>
<h2>artist</h2>
</div></div>

    <?php
}
?>
<div class='burger'></div>
</div>

</div>
