<?php
ini_set('max_input_vars', 500);
error_reporting(E_ALL);
ini_set('display_errors', '1');
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

//  print_r($_POST);

    $id = '00000000';
    $title = '';
    $width = '0';
    $height = '0';
    $month = '';
    $year = '';
    $save_or_remove = 'save';
    $sold = false;

    if (isset($_POST['imgCount'])) {
      echo "Count: ". $_POST['imgCount'];
      $imageCount = $_POST['imgCount'];

      $changes = json_decode($imageCount, true);
        
    echo "<br>";

    //  print_r($_POST);
        $numberOfEntries = count($changes);
   

      if ($numberOfEntries && $numberOfEntries > 0) {

        for ($i = 0; $i < $numberOfEntries; $i++) {
            
            $paintingNumber = $changes[$i];

            $title = $_POST['title-' . $paintingNumber];
            if ($title) {
            echo "Title: " . $title;
            } 
            echo "<br>";
        }
      }

    //   if ($imageCount && $imageCount > 0) {


    //     for($i=0; $i< $imageCount; $i++) {

    //         echo "Painting: " . $i;
            
    //         $title = $_POST['title-' . $i];
    //         if ($title) {
    //         echo "Title: " . $title;
    //         } else { echo "no title."; }
    //         echo "<br>";
    //     }
    //   }
    }
    

}

?>