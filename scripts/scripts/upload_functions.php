<?php
function processPost() {
    $error = [];
    if ($_SERVER["REQUEST_METHOD"] == "POST") { 
         if (isset($_POST['submit']))
             { $error = analyzeNewInfo(); }  
    if (!$error) {
        $artwork = $_SESSION['updated_artwork'];
        if ($new_id) {
            $image = $_SESSION['newImage'];
            $image->artwork_id = $new_id;
            $image->save();
            header("Location: dashboard.php");
        }
    }
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
        print_r('there was an issue with the image');
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
            echo "\nno errors with image so far.<br>\n";
            // upload the file -- and create the new imageObject -- but it is not yet saved
            $newImage = upload_image_file();  
           
            if ($newImage) {
             // echo "uploaded image.<br>";
  
              
              $_SESSION['newImage'] = $newImage;
              $_SESSION['tmpFile'] = $newImage;
             echo "<br>Setting tmpFile to: ".$_SESSION['tmpFile']."<br>";
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

    echo "<br>Errors: ".serialize($errors);
    return $errors;
}


function addJsonLineFromTextFile($line) {
  $artwork = explode(",-*-,", $line);

  $json_line = "    { \"id\":  \"" . $artwork[0]. "\", \"title\": \"temp\", ";
    $json_line = $json_line . "\"width\": \"".$artwork[2]."\", ";
    $json_line = $json_line . "\"height\": \"".$artwork[3]."\", ";
         
    $json_line = $json_line . "\"month\": \" \", ";
    $json_line = $json_line . "\"year\": \"2023\" ";
    $json_line = $json_line . "},";
    return $json_line;
}

function addJsonLineFromJsonFile($line) {
  if (strlen($line) >  16) {
    // an actual painting object

//     $singleLine = json_decode($jsonString, true);

// // Access individual items using the array keys
// $id = $singleLine['id'];
// $title = $singleLine['title'];
// $width = $singleLine['width'];
// $height = $singleLine['height'];
// $month = $singleLine['month'];
// $year = $singleLine['year'];

// Check if the last character is a comma
if (substr($line, -1) !== ',') {
  // Add a comma to the end of the string
  $line .= ',';
}

return $line;
  } else {
    return null;
  }
}

function saveToDb($newDateTime) {
//$file_path = 'uploads/painting_list.txt';
$json_path = 'uploads/generated_list.json';

$json_lines = [];
array_push($json_lines, "{");
array_push($json_lines, "  \"paintings\": [");

// Check if the file exists
if (file_exists($json_path)) {

//JSON version

// $file_lines = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
// foreach($file_lines as $line) {
//   $json_line = addJsonLineFromTextFile($line);
//   array_push($json_lines, $json_line);
// }

$file_lines = file($json_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach($file_lines as $line) {
  $json_line = addJsonLineFromJsonFile($line);
  if ($json_line) {
  array_push($json_lines, $json_line);
  }
}

$json_line = "    { \"id\":  \"" . $newDateTime. "\", \"title\": \"temp\", ";
  $json_line = $json_line . "\"width\": \"0\", ";
  $json_line = $json_line . "\"height\": \"0\", ";
  $json_line = $json_line . "\"month\": \" \", ";
  $json_line = $json_line . "\"year\": \"2023\" ";
  $json_line = $json_line . "}";


 // $json_line = "another";
array_push($json_lines, $json_line);


//TEXT VERSION
    // Read the file contents
   // $file_contents = file_get_contents($file_path);

    // $string_to_add = $newDateTime . ",-*-,0,-*-,0,-*-,2023";
    // $file_lines[] = $string_to_add;

        // Prepare the data to be saved back to the file
        // $data_to_save = implode(PHP_EOL, $file_lines);
        // Save the data back to the file
        // file_put_contents($file_path, $data_to_save);
        // Output each line separately
        // foreach ($file_lines as $line) {
          // echo $line . "<br>"; // You can replace "<br>" with your desired line separator
      // }
// } else {
    // echo "File not found or inaccessible.";
// }

// FINISH JSON version
array_push($json_lines, "  ]");
array_push($json_lines, "}");

$data_to_save = implode(PHP_EOL, $json_lines);
file_put_contents($json_path, $data_to_save);


}

}