<?php
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');

$file = 'uploads/generated_list.json';

$json_from_file = [];

if (file_exists($file)) {
   // $json_from_file = file('uploads/generated_list.json', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
   $json_from_file = file_get_contents($file);
}

echo $json_from_file;


?>