<?php 
session_start();
include_once "config.php";
echo "<div class='debuggingBox'>";
include_once "classes/artworks.php";
include_once "scripts/load.php"; 
include_once "scripts/in_memory_functions.php"; 

load_full_works();
$db = $_SESSION['artwork_db'];
$images = load_images($db, 'current');
$shows = load_shows($db);
$works = $_SESSION['works'];
$collections = splitIntoCategories();
$_SESSION['collections'] = $collections;
$mostCurrentId = get_most_current_id();
echo "</div>"; // end of debugging box
?>
<!DOCTYPE html>
<meta charset = "UTF-8">
 <!-- name="viewport" content="initial-scale=1.0, user-scalable=1"> -->

<meta name="viewport" content="width=device-width,initial-scale=1">
<meta property="og:title" content="Jerry Frost Artist">
<meta property="og:type" content="website">
<meta property="og:description" content="San Francisco Painter">
<meta property="og:image" content="http://jerryfrost.com/interface/jerry_og2.jpg">
<meta property="og:url" content="http://jerryfrost.com/">
<meta property="fb:app_id" name="fb_app_id" content="429912884431270"/>

<html lang="en">
<?php 
include 'parts/head.php';
?>
<body>
    <div class='homeframer group'>
        <?php 
        $page = 'home';
        include_once 'parts/titlebar.php';
        include_once 'parts/navigation.php'; 
        include_once 'parts/main_image.php';
        include_once 'parts/statement.php'; 
        include_once 'parts/shows.php';
        include_once 'parts/contact.php';
        include_once 'parts/bio.php'; 
        ?>

        <p class="copyrighttext">
        <span class='nobreak'>
        All images are copyrighted &copy; 2019,</span>
        <span class='nobreak'> Jerry Frost, all rights reserved.</span>
        </p>


    </div>
<?php

?>
</body>
</html>
