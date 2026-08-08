<?php
function processPost() {
    $error = [];
    if ($_SERVER["REQUEST_METHOD"] == "POST") { 
         if (isset($_POST['submit']))
             { $error = analyzeNewInfo(); }  
    // if (!$error) {
    //     $artwork = $_SESSION['updated_artwork'];
    //     if ($new_id) {
    //         $image = $_SESSION['newImage'];
    //         $image->artwork_id = $new_id;
    //         $image->save();
    //         header("Location: dashboard.php");
    //     }
    // }
    }
    return $error;
  }
  
  function analyzeNewInfo() {
    //  echo "Got a new post.<br>";
     // print_r( $_FILES );
      $error_array = [];
  
      if ($_FILES && $_FILES['uploadfile'] && $_FILES['uploadfile']['tmp_name']==null) {
        array_push($error_array, 'uploadfile');
      } else {
        $error_array = handleImageUploadInfo();
      }
      if (count($error_array)>0) {
         // echo "There was an issue with the image:";
      }
      return $error_array;
}

  
function handleImageUploadInfo() {
  // echo "\nAbout to handle upload info.\n";
    $error = null;
    $_SESSION['updated_artwork'] = null;

    if (isset($_FILES) && $_FILES && $_FILES['uploadfile']['tmp_name']!=null) {
        // echo "\nuser chose a new image to upload.<br>\n";
        $error = check_image_file_for_upload_errors();

        if (count($error) < 1) {
            // upload the file -- and create the new imageObject -- but it is not yet saved
            $newImage = upload_image_file();

            if ($newImage) {
              $_SESSION['newImage'] = $newImage;
              $_SESSION['tmpFile'] = $newImage;
            }
        } else {
            $_SESSION['tmpFile'] = $_FILES['uploadfile']['tmp_name'];
        }
    }
    return $error;
}  


function upload_image_file() {
    $newImage = null;
    $target_dir = "uploads/artwork/";
    $current_time = time();
    $extension = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_EXTENSION);
    $image_path = $current_time . '.jpg'; 
    $target_file = $target_dir . $image_path;
    $image_info = getimagesize($_FILES["uploadfile"]["tmp_name"]);
    if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $target_file)) {
      saveToDb($current_time);
      return $current_time;
    }
    return false;
}


function check_image_file_for_upload_errors() {
    $errors = [];
    $upload_error = false; 
    $extension = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_EXTENSION);
    // Allow certain file formats
    if ( ( $extension != "jpg") && 
         ( $extension != "JPG") &&
         ( $extension != "Jpg") &&
         ( $extension != "jpeg") &&
         ( $extension != "Jpeg") 
          ) {
        array_push($errors,  "Only Jpeg files are allowed." );
    }
    // Check file size
    if ($_FILES["uploadfile"]["size"] > 6000000) {  // Imagefile must be less than 6 megabytes
        array_push($errors, "Your file is too large."); }

    if ($_FILES["uploadfile"]["size"]==0) { array_push($errors, "Your file size was zero.");}

    return $errors;
}


function saveToDb($newDateTime) {
$json_path = 'uploads/generated_list.json';

$json_data = ['paintings' => []];
if (file_exists($json_path)) {
    $existing = json_decode(file_get_contents($json_path), true);
    if (is_array($existing) && isset($existing['paintings'])) {
        $json_data = $existing;
    } else {
        error_log('saveToDb: uploads/generated_list.json is not valid JSON; starting a fresh paintings list.');
    }
}

$json_data['paintings'][] = [
    'id' => (string) $newDateTime,
    'title' => 'temp',
    'width' => '0',
    'height' => '0',
    'month' => date('F'),
    'day' => date('j'),
    'year' => date('Y'),
    'categories' => [],
    'sold' => false,
];

file_put_contents($json_path, json_encode($json_data, JSON_PRETTY_PRINT));
}