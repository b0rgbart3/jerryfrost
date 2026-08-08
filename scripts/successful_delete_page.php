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
<head>
<title>Artist: Jerry Frost</title>
<script src='js/previewimages.js'></script>
<link rel="stylesheet" type="text/css" href="css/basics.css" />
</head>
<body>

<h1>You successfully deleted a painting.</h1>
<br>
<a href='review.php'>Go back to the admin page.</a>
<br><br/>
<a href='index.php'>Go back home.</a>
</body>
</html>