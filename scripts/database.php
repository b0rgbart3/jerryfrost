<?php 
error_reporting(-1);
require 'app_config.php';
// echo "<h1>Establishing DB Connection</h1>";
// echo "<p>HOST: ".DB_HOST."</p>";
// echo "<p>USER: ".DB_USER."</p>";
// echo "<p>DB: ".DB_NAME."</p>";
$db = new mysqli(DB_HOST, DB_USER, DB_PW, DB_NAME);
/* check connection */
if ($db->connect_errno) {
    printf("<br><h1>Connection failed:</h1><p> %s </p>\n", $db->connect_error);
    exit();
}

if (!$db) {
    echo "<h1>Error:</h1><p> Unable to connect to MySQL.</p>" . PHP_EOL;
    exit;
} else {
 // echo "Have Data";
    $_SESSION['artwork_db'] = $db;
}
?>
