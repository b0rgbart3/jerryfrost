<?php

include_once 'scripts/edit_functions.php';
// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    // Retrieve and sanitize the 'id' value
    $id = htmlspecialchars($_GET['id']);

    // Use the $id variable as needed
    echo "The ID from the URL is: $id";
} else {
    // Handle the case when 'id' is not present in the URL
    echo "No ID parameter found in the URL.";
}


     
        $message = remove_this_painting($id);
        // echo "Status of removal: ". $message;

        if ($message === "Success") {
           header("Location: successful_delete_page.php");
        } else {
           header("Location: error_delete_page.php");
        }
?>
