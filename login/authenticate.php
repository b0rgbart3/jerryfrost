<?php
session_start();

// ini_set('session.save_path', '../../sessions'); //adjust the path if needed
//phpinfo();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$_SESSION['logged_in'] = false;
// Your authentication logic
function authenticate($username, $password) {
    // Your custom logic here
    // Check against environment variables, database, etc.
    // Return true if authentication is successful, false otherwise

    $algorithm = "sha256";
    $correct_username_hash = '8c0e4fa315dc2d2e5dab38771aaa61ccf3e773f1454d41fb236d8c9ef7aea30f';
    $correct_password_hash = '7f18041501a6073856a11aeccde8725cb9fe20ddefe45b5772ae880290fb0f2c';

// Generate hashes
$hashedUsername = hash($algorithm, $username);
$hashedPassword = hash($algorithm, $password);

    if ($hashedUsername == $correct_username_hash && $hashedPassword == $correct_password_hash) {
        return true;
    } else {
        return false;
    }
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate the credentials
    if (authenticate($username, $password)) {
        // Authentication successful
        // Redirect to the protected area
        $_SESSION['logged_in'] = true;
  
 
       header('Location: ../review.php');
exit();
        exit();
    } else {
        // Authentication failed
        echo 'Invalid login credentials. Please try again.';
        echo '<a href="index.php">Try again</a>';
        ob_end_flush(); 
    }
}

