<?php 
$requestUri = $_SERVER['REQUEST_URI'];

// Check if there are additional path segments after index.php
if (strpos($requestUri, 'index.php/') !== false) {
    // Redirect to a 404 page or your homepage
    header('Location: /404.php'); // Adjust the path accordingly
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARTIST: Jerry Frost</title>
    <meta property="og:title" content="Artist: Jerry Frost">
    <meta property="og:type" content="website">
    <meta property="og:description" content="A portfolio website of paintings by artist Jerry Frost.">
    <meta property="og:image" content="http://jerryfrost.com/interface/jerry_og2.jpg">
    <meta property="og:url" content="http://jerryfrost.com/">
    <meta property="fb:app_id" name="fb_app_id" content="429912884431270"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,500,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Merriweather" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="stylesheet" type="text/css" href="css/basics.css" />
    <script src='js/shared.js'></script>
    <script src='js/group.js'></script>
    <script src='js/index.js'></script>
</head>
<body>
<div id='largeDSWrapper' class='largeDSWrapper hidden'>
    <img id='largeDS' class='largeDS'>
</div>
    <div class='logoWrapper' id='logoWrapper'>
        <div class='logo' id='logo'>
            <div class='burger' id='burger'>
              <img src='interface/burger.svg' id='burger-image'>
            </div>
            <div class='artist' id='artist'>
              <span class='artistSpan' id='artist-span'>ARTIST:</span>
              Jerry Frost
            </div>
            <div class='filtersIcon hidden' onClick=expandFilterBox(event) id='filterIcon'><img src='interface/filters.svg'/></div>
        </div>
   
        <div id='menuWrapper' class='menuWrapper hidden'>
        <div id='menu' class='menu'>
            <ul>
                <li id='home'>home</li>
                <li id='bio'>biography</li>
                <li id='statement'>artist statement</li>
                <li id='contact'>contact jerry</li>
         
                <!-- <li id='catalog'>full catalog</li> -->
            </ul>
        </div>
        </div>
    </div>

    <div class='extras' id='extras'>

        <div class='filters' id='queryWrapper'>
            <div class='queryForm'>
                <label name='queryTitle'>Search for title:</label>
                <input type='text' size='20' id='query' name='query' class='queryInput'/>
            <a onClick=filterFromQuery()><div class='filterIcon'><img src='interface/filter-icon.svg'></div></a>
            </div>
            <br clear='all'/>
            <ul id='filters'>
            <!-- <li class='filter' data-filter='available'>Available</li>
            <li class='filter' data-filter='sold'>Sold</li>
            <li class='filter filterOption' data-filter='all'>All</li> -->
            </ul>
            <div id="categoryBoxes" class='categoryBoxes'>
            </div><br clear='all'>
        </div>
        <!-- <div class='showFilters hidden' id='showFilterButton'>Show Filters</div> -->


        <div id='counter' class='counter'>Paintings</div>
    </div>
    
<div class='navigatorWrapper' id='navigatorWrapper'>


    <div id="paintingNavigator" class='paintingNavigator'>
    </div>
</div>
</body>
</html>





