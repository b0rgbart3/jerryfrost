<?php 
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

$category = null;
if (isset($_GET['category'])) {
$category = $_GET['category'];
}
if (isset($_GET['id'])) {
$id = $_GET['id'];
}

?>
<!DOCTYPE HTML PUBLIC >
<html lang="en">
<head>
<link rel="icon" href="jerry-favicon-32.png" sizes="32x32">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta property="og:title" content="Jerry Frost Artist">
<meta property="og:type" content="website">

<meta property="og:description" content="San Francisco Painter">
<meta property="og:image" content="http://jerryfrost.com/interface/jerry_og2.jpg">
<meta property="og:url" content="http://jerryfrost.com/">
<meta property="fb:app_id" name="fb_app_id" content="429912884431270"/>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script src='/js/nav.js'></script>

      <link href="https://fonts.googleapis.com/css?family=Roboto:300,500,700" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Merriweather" rel="stylesheet">
  

    <title>Jerry Frost - Artist</title>
    <link rel="Stylesheet" href="/style/style_sheet.css">   
    <link rel="Stylesheet" href="/style/art.css">   
    <link rel="Stylesheet" href="/style/custom_select.css">   
    <link rel="Stylesheet" href="/style/nav.css">  


</head>

<script src="https://hammerjs.github.io/dist/hammer.js"></script>

<?php 
echo "<script>window.currentId = ".$id.";";
echo "window.currentCat='".$category."';";
echo "</script>";
?>

<body>
<link rel="Stylesheet" href="/style/catalog.css"> 

<div class='framer group'>
<?php 

include_once 'parts/titlebar.php';
include_once 'parts/navigation.php'; 
if ($category != 'all') {
echo "<a href='catalog.php?cat=".$category."'>"; }
else {
    echo "<a href='catalog.php?cat=current'>";
}

?>
<div class='catalogLink'></div></a>
<div class='mySelector' id='mySelections'>
    <div class='mySelectorTop'>Category <div class='mySelectorDownArrow'></div></div>
    <div class='mySelections group' >

        <div class='mySelectorItem' data-choice='current' data-id='<?php
        echo $collections['current'][0]->id;
        ?>'>Most Current
        </div>
        <div class='mySelectorItem' data-choice='social' data-id='<?php 
        echo $collections['social'][0]->id; ?>'>Social Commentary
        </div>
        <div class='mySelectorItem' data-choice='abstract' data-id='<?php
        echo $collections['abstract'][0]->id; ?>'>Abstract
        </div>
        <div class='mySelectorItem' data-choice='figurative' data-id='<?php
        echo $collections['figurative'][0]->id; ?>'>Figurative
        </div>
        <div class='mySelectorItem' data-choice='landscape' data-id='<?php 
        echo $collections['landscape'][0]->id; ?>'>Landscapes
        </div>
        <!-- <div class='mySelectorItem' data-choice='all' data-id='<?php 
      //  echo $collections['all'][0]->id; ?>'>All Paintings
        </div> -->
    </div>
</div>
<?php


 include_once 'parts/art_displayer.php';

?>


    
</body>
</html>