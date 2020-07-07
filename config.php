<?php 
$isLocal = true;
include_once "scripts/pathinfo.php";
// This is the path to load css and js files
$resource_path = get_resource_path($isLocal);
//echo "RESOURCE_PATH: " . $resource_path;
$path = get_path();
//echo "PATH:".$path;
?>