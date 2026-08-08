<?php
session_start();
$logged_in = $_SESSION['logged_in'];

if (!$logged_in) {
    header("Location: ./login/"); /* Redirect browser */
}

include_once 'scripts/pathinfo.php';
$path = get_path();

 include_once 'scripts/upload_functions.php';
 include_once 'scripts/edit_functions.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$months = [
    'January', 'February', 'March', 'April',
    'May', 'June', 'July', 'August',
    'September', 'October', 'November', 'December'
  ];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

//    print_r($_POST);

    $id = '00000000';
    $title = '';
    $width = '0';
    $height = '0';
    $month = '';
    $year = '';
    $save_or_remove = 'save';
    $sold = false;

    if (isset($_POST['submit_button'])) {

        if ($_POST['submit_button'] == 'REMOVE THIS PAINTING') {
            $save_or_remove = 'remove';
        }
    }
    if (isset($_POST['inputId'])) {
        $id = $_POST['inputId'];
        }
        

    if ($save_or_remove == 'save') {

    if (isset($_POST['inputTitle'])) {
        $title = preg_replace("/[^a-zA-Z0-9'\s]/", "", $_POST['inputTitle']);
        if (strlen($title) > 30) {
            $title = 'Temporary Title';
        }
        }
    if (isset($_POST['inputWidth'])) {
        $width = $_POST['inputWidth'];
        if (strlen($width) > 4) {
            $width = '0';
        }
        }
    if (isset($_POST['inputHeight'])) {
        $height = $_POST['inputHeight'];
        if (strlen($height) > 4) {
            $height = '0';
        }
        }
    if (isset($_POST['monthSelect'])) {
        $month = $_POST['monthSelect'];
        }
    if (isset($_POST['daySelect'])) {
        $day = $_POST['daySelect'];
        }
    else {
        $day = '1';
    }
    if (isset($_POST['yearSelect'])) {
        $year = $_POST['yearSelect'];
        
        if (strlen($year) > 4) {
            $year = '2023';
        }
        }
    if (isset($_POST['sold'])) {
        if ($_POST['sold'] === 'on') {
            $sold = "true";
        }
       else {
        $sold = "false";
       }
        }
        $chosen_categories = [];
        $categoriesArray = ['figurative', 'social-commentary', 'abstract', 'landscape', 'animals'];
        foreach($categoriesArray as $category) {

            if (isset($_POST[$category])) {

                $chosen_categories[] = $category;
            }
        }



    if ($title && $id) {
        save_updated_info($id, $title, $width, $height, $month, $day, $year, $chosen_categories, $sold);
    } 
    header("Location: successful_edit.php");
    }

            
        
    //    header("Location: error_delete_page.php");
    //     $message = remove_this_painting($id);
        // echo $message;

        // if ($message === "Success") {
        //    header("Location: successful_delete_page.php");
        // } else {
        //    header("Location: error_delete_page.php");
        // }
    //}
//  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Confirmation</title>
    <script>
    function doubleCheck(saveOrRemove) {
        console.log('Save or remove: ', saveOrRemove);
        if (saveOrRemove !== 'save') {
        const confirmation=confirm('Are you sure you want to remove this painting?');
      if (confirmation) { window.location='oktoremove.php?id=<?php echo $id; ?>';} 
      else {window.location='review.php';}  //notok.php
        } 
        else {
            window.location='review.php';
        }
    }  
    window.onload = function() {

        var myVar = "<?php echo $save_or_remove; ?>";
        doubleCheck(myVar);
    };
      </script>
      <link rel="stylesheet" type="text/css" href="css/basics.css" />
<link rel="stylesheet" type="text/css" href="css/review.css" />
</head>
<body>

