<?php
session_start();
$filename = 'uploads/artwork/list.txt';
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $file_lines = [];
    if (file_exists($filename)) {
        $file_lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }

    $ids = array();
    $newList = array();
    $index = 0;
    echo "<br>List:". count($file_lines);
    foreach($file_lines as $line) {
        $thisId = explode(".", $line)[0];
        echo "<br>".$index."ID: " . $thisId;
        $ids[] = $id;
        $index++;
        if ($thisId == $id) {
            $foundIndex = $index;
        } else {
            $newList[] = $line;
        }
    } 

    echo "<br>NewList:". count($newList);

    if (file_exists($filename)) {

            $data_to_save = implode(PHP_EOL, $newList);
            file_put_contents($filename, $data_to_save);
    }
}

header("Location: review.html"); /* Redirect browser */

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
<h1>Deleted the painting</h1>
<a href='index.html'>Home</a><br>

 
</body>
</html>