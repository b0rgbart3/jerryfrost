<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
// if (file_exists('uploads/artwork/list.txt')) {
//     // Read the file contents
//    // $file_contents = file_get_contents($file_path);

//     $file_lines = file('uploads/artwork/list.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
//     echo "FILE:".serialize($file_lines);
?>
<html>
<meta charset = "UTF-8" name="viewport" content="initial-scale=1.0, user-scalable=1">
<html lang="en">
<head>
<title>Artist: Jerry Frost</title>
<script src='js/previewimages.js'></script>
<link rel="stylesheet" type="text/css" href="css/basics.css" />
<style>
    /* Basic styling for the images */
    img {
        max-width: 200px;
        max-height: 200px;
        margin: 5px;
    }
</style>
</head>
<body>
<a href='index.html'>Home</a><br>
<h1>Review the collection:</h1>

    <div id="image-gallery"></div>

    <script>
        // JavaScript code to load and display images from a directory
        window.addEventListener('load', function() {
            const imageGallery = document.getElementById('image-gallery');
            const imageDirectory = 'uploads/artwork/'; 
            
            // Replace this list with actual image names if you know them in advance
            const imageNames = [
                'image1.jpg',
                'image2.jpg',
                'image3.jpg',
                // Add more image names as needed
            ];

            // Loop through the image names and create img elements for each image
            imageNames.forEach(imageName => {
                const img = document.createElement('img');
                img.src = imageDirectory + imageName;
                imageGallery.appendChild(img);
            });
        });
    </script>
</body>
</html>


</body>
</html>