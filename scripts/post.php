<?php
session_start();
$logged_in = $_SESSION['logged_in'];

if (!$logged_in) {
    header("Location: ./login/"); /* Redirect browser */
}

include_once 'scripts/pathinfo.php';
$path = get_path();
// include_once 'scripts/database.php';
include_once 'scripts/upload_functions.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$today = date("Y-m-d H:i:s");
$width = '0';
$height = '0';
$file_error = null;
$error = [];
$newImage = null;
$uploadFile = null;
$temp = false;
$hasImage = false;
$_SESSION['updated_artwork'] = null;
$newwork = [ /*id*/ '0', 'title',$today, /*width*/'',/*height*/ '', /*category*/'', /*archived*/'', /*sold*/''];
// we are proccessing a post request


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
<h1>Added a new painting:</h1>
<a href="index.html">Home</a>
</body>
</html>

<?php
$error = processPost();
header("Location: review.php"); /* Redirect browser */

?>