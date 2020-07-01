<?php 

include_once '../scripts/database.php';

function dock() {
$db = $_SESSION['artwork_db'];

$sqlQuery = "SELECT * FROM `dock` WHERE `id` = '101';";
$result = mysqli_query($db, $sqlQuery);

$data = [];
if ($result) {
    while ($row = mysqli_fetch_row($result)) {
            array_push($data, $row);
    }

   // print_r($data);
    if ($data) {
        return($data[0][2]);
    }
}
}
//print_r($data);
