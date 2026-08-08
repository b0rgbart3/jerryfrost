<?php

include_once 'scripts/edit_functions.php';
// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    // Retrieve and sanitize the 'id' value
    $id = htmlspecialchars($_GET['id']);

    // Use the $id variable as needed
    // echo "The ID from the URL is: $id";
} else {
    // Handle the case when 'id' is not present in the URL
  // echo "No ID parameter found in the URL.";
}


     
        $message = remove_this_painting($id);
        //  echo "Status of removal: ". $message;

        if ($message === "Success") {
          // echo "Successfully removed that painting.<br><br>Click <a href='review.php'>here</a> to go back to the admin page.";
           header("Location: successful_delete_page.php");
        } else {
          // echo "There was a problem trying to remove that painting.<br><br>Click <a href='review.php'>here</a> to go back to the admin page.";
          header("Location: error_delete_page.php");
        }
?>
