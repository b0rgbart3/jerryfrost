<?php
include_once '../classes/images.php';
// This does a 'pre-flight' check on the image before we actually upload it

function check_image_file_for_upload_errors() {
    $errors = [];
    $upload_error = false; 
    $target_dir = "../uploads/artwork/";
    $originalfilename = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_FILENAME);
    $extension = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_EXTENSION);
    // Allow certain file formats
    if ( ( $extension != "jpg") && 
         ( $extension != "JPG") &&
         ( $extension != "Jpg") &&
         ( $extension != "jpeg") &&
         ( $extension != "Jpeg") && 
         ( $extension != "png") &&
         ( $extension != "PNG") &&
         ( $extension != "Png") &&
         ( $extension != "Gif") &&
         ( $extension != "GIF") &&
         ( $extension != "gif") ) {
        array_push($errors,  "Only JPG, JPEG, PNG & GIF files are allowed." );
    }
    // Check file size
    if ($_FILES["uploadfile"]["size"] > 6000000) {  // Imagefile must be less than 6 megabytes
        array_push($errors, "Your file is too large."); }

    if ($_FILES["uploadfile"]["size"]==0) { array_push($errors, "Your file size was zero.");}

    $fullFileName = $target_dir.$originalfilename.".".$extension;
    //echo "checking: " . $fullFileName."<br>";

    // I don't need to worry if the file already exists - because I'm adding the timestamp
    // to it - so there's not really any way it could.  *see notes in upload_image_file()

    // if (file_exists($fullFileName)) {
    //     echo "This file already has been uploaded.<br>";
    //     array_push($errors, "A file with that name has already been uploaded.");
    // }


    return $errors;
}

// I only want lowercase simplified extensions - so if the user had a different version,
// let's clean it up before upload it.
function cleanExtensions($extension) {
    $better = $extension;
    switch($extension) {
        case 'jpg':
        case 'JPG':
        case 'jpeg':
        case 'Jpeg':
        case 'JPEG':
          $better = 'jpg';
          break;
        case 'PNG':
        case 'png':
        case 'Png':
          $better = 'png';
          break;
        case 'GIF':
        case 'gif':
        case 'Gif':
            $better = 'gif';
            break;
        default:
        break;
    }
    return $better;
}
// Here we are actually uploading the image file.  Note: This also creates and returns a new Image Object



function upload_image_file() {
  
    $newImage = null;

    if ($_SERVER["REQUEST_METHOD"] == "POST") { 
        
            $imageWidth = 0;
            $imageHeight = 0;
            $target_dir = "../uploads/artwork/";
            $originalfilename = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_FILENAME);


            //echo "original:".$originalfilename;


            $trimmed = preg_replace('/\s+/', '', $originalfilename);
           // echo "trimmed:".$trimmed;
            $safe = preg_replace("/[^A-Za-z0-9 ]/", '', $trimmed);
           // echo "safe:".$safe;

            $current_time = time();
            $extension = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_EXTENSION);
            $clean_extension = cleanExtensions($extension);
            //$image_path = $current_time.'.'. $extension;
            $image_path = $safe.'_'.$current_time.'.'. $clean_extension;
            
            $target_file = $target_dir . $image_path;

            $image_info = getimagesize($_FILES["uploadfile"]["tmp_name"]);

            $newImage = null;
            if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $target_file)) {

                 //here we can create thumbnails by create_thumb() function
             //it takes 5 parametes
             //1- original image, 2- file extension, 3-thumb full path, 4- max width of thumb, 5-max height of thumb
             create_thumb($target_file,$clean_extension,'../uploads/thumbs/'.$image_path,200,200);

                $newImage = new Images( [0,0, $image_path, $image_info[0], $image_info[1] ] );
                
            } else {
                        echo "Sorry, there was an error uploading your file.";
                        $success = false;
                    }
        

    }
    return $newImage;
}

//function to create thumbnail
function create_thumb($target,$ext,$thumb_path,$w,$h){
   // echo "Thumb path: " . $thumb_path;

    list($w_orig,$h_orig)=getimagesize($target);
    $scale_ratio=$w_orig/$h_orig;
    if(($w/$h)>$scale_ratio)
        $w=$h*$scale_ratio;
    else
        $h=$w/$scale_ratio;

if($w_orig<=$w){
    $w=$w_orig;
    $h=$h_orig;
}
$img="";
if($ext=="gif")
    $img=imagecreatefromgif($target);
else if($ext=="png")
    $img=imagecreatefrompng($target);
else if($ext=="jpg")
    $img=imagecreatefromjpeg($target);

$tci=imagecreatetruecolor($w,$h);
imagecopyresampled($tci,$img,0,0,0,0,$w,$h,$w_orig,$h_orig);
imagejpeg($tci,$thumb_path,80);
imagedestroy($tci);
}//end function create_thumb()



function check_piece_form_for_errors() {
    $this_error = null;
    $form_errors = [];
   // if (!isset($_POST['category'])) { $error = 'category'; array_push($errors,$error);}
    if (!isset($_POST['title']) || $_POST['title']=='') { $this_error = 'title'; array_push($form_errors,$this_error); }
    if (!isset($_POST['created'])) { $error = 'created'; array_push($from_errors,$this_error);}
    if (!isset($_POST['width']) || $_POST['width']=='') { $this_error = 'width'; array_push($form_errors,$this_error); }
    if (!isset($_POST['height'])|| $_POST['height']=='') { $this_error = 'height'; array_push($form_errors,$this_error); }

    return $form_errors;
    
}

?>