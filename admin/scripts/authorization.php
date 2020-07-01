<?php 

function authorize() {
    if ($_SESSION['logged_in']) {
        return true;
    } else {
        header("Location: index.php");
    }
}
?>
