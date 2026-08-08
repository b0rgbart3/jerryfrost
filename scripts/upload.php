<?php
session_start();
$logged_in = $_SESSION['logged_in'];

if (!$logged_in) {
    header("Location: ./login/"); /* Redirect browser */
}

?>
<html>
<meta charset = "UTF-8" name="viewport" content="initial-scale=1.0, user-scalable=1">
<html lang="en">
    <style>
        .hidden {
            opacity:0;
        }

        #loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            font-size: 18px;
        }

        #loading-indicator {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        </style>
<head>
<title>Artist: Jerry Frost</title>
<script src='js/previewimages.js'></script>
<link rel="stylesheet" type="text/css" href="css/basics.css" />
<script>
    function react() {
        const content = document.getElementbyId('content');
        content.classList.add('hidden');
    }

   
    window.addEventListener('load', function() {
    document.getElementById('myForm').addEventListener('submit', function () {
            // Show the loading overlay when the form is submitted
            console.log('Show Spinner.');
            document.getElementById('loading-overlay').style.display = 'flex';
        });
    })
    </script>
</head>
<body>
<a href='review.php'>Review</a><br>
<h1>Add a new painting</h1>
<form action="post.php" method='post' class='basicform group' enctype="multipart/form-data" id='myForm'>
<input type="file" name="uploadfile" id="uploadfile" onchange="previewFile()">
<br/>
<div id='content'>
<div id='newImage'>
<img class='previewImage hidden' id='previewImage'><br>
</div>
<button class='upload hidden' type='submit' name='submit' id='upload' value='submit'>Yes - add this painting to the website</button></form>
<br />
<a href='upload.php'><button class='upload hidden' id='cancel'>No - choose a different image</button></a>
</div>

<div id="loading-overlay">
        <div id="loading-indicator"></div>
        Loading...
    </div>
</body>
</html>