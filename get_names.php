<?php
$file_lines = [];
if (file_exists('uploads/painting_list.txt')) {
    $file_lines = file('uploads/painting_list.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

// Encode the PHP array as a JSON string and output it
header('Content-Type: application/json');
echo json_encode($file_lines);

?>