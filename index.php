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
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

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
         
        </div>
   
        <div id='menuWrapper' class='menuWrapper hidden'>
        <div id='menu' class='menu'>
            <ul>
                <li id='home'>home</li>
                <li id='gallery'>gallery</li>
                <li id='bio'>biography</li>
                <li id='statement'>artist statement</li>
                <li id='contact'>contact jerry</li>
        
                <!-- <li id='catalog'>full catalog</li> -->
            </ul>
        </div>
        </div>
    </div>



    
    <div class='galleryPic'><img src='interface/gallery.jpg'></div>

   <div class='latestWork' id="galleryLink"><a href='gallery.php'>See the Latest Work</a></div>
    </div>
</div>
 
<div class='title'><img src='interface/jerry_frost_title.png'></div>
<div class='blurb'><p>Step into a world of color and form beyond imagination.  Jerry Frost's work exists in a dream-like realm where childhood memories and emotions come to the surface with a vibrance and boldness that is as expressive as his passion for and love of humanity.  When you observe enough of Jerry's work you begin to recognize his unique symbolic language and repeating themes of indigeneity, identity, and sexuality.  He captures the tensions of living in a world of oppression, apartheid and control while simultaneously conveying an inner spirit of freedom, love and self expression. You may find yourself with unexpected emotions.  You can't look at Jerry's work without laughing or crying or being in awe.  Sometimes all in the same piece. </p>
<p>Jerry's work extends the traditions of abstraction, surrealism, and abstract expressionism.  His works have the compositional rhythm and whimsy of Wassily Kandinsky, the playfulness and melancholy of Marc Chagal, the expressiveness and energy of Jackson Pollock.  Whether they are psychological landscapes like Salvador Dali or the tortured and distorted figures of Francis Bacon, Jerry's work is intensely personal.  Each piece is a journey into his psyche and the unconcious mind.</p>
<p>Jerry is a consumate craftsman.  He is steadfast in his pursuit of dynamic compositions -- always directing the viewers attention and entertaining us with a cascade of color and texture that keeps you guessing and wondering just where is this magical world that he seems to live in.  As a member of the Shasta Nation his work also extends the tradition of many Native American artists like Fritz Scholder or more recently Virgil Ortiz - whose work has transcended the confines of craft and folk-art and is more suited to the company of the master painters of high art of the twentieth century.</p>
</div>
<div class='textnav'><a href='gallery.php'>Gallery</a> | <a href='bio.php'>Bio</a> | <a href='statement.php'>Artist's Statement</a> | <a href='contact.php'>Contact</a> 
</div>
</body>
</html>





