<?php
//phpinfo();
// for some reason this class definition needs to get loaded in before the
// session start call ??
require_once '../classes/artworks.php';
require_once '../classes/images.php';
session_start();
include_once 'scripts/authorization.php';
include_once 'scripts/save.php';
include_once '../scripts/in_memory_functions.php';
include_once 'scripts/upload_image_file.php';
include_once '../classes/images.php';
authorize();
include_once 'head.php';
$today = date("Y-m-d H:i:s");


$width = '0';
$height = '0';
$file_error = null;
$error = [];
$newImage = null;
$uploadFile = null;
$temp = false;
$_SESSION['updated_artwork'] = null;


function analyzeNewInfo() {
      //  echo "Got a new post.<br>";

        $imageCount = count($_FILES["uploadfile"]["name"]);

        for ($i = 0; $i < $imageCount; $i++) {

                $target_dir = "../uploads/artwork/";
                $path_parts = pathinfo($_FILES["uploadfile"]["name"][$i]);
                $current_time = time() + $i;

                
                $originalfilename = pathinfo($_FILES["uploadfile"]["name"][$i], PATHINFO_FILENAME);
                $extension = pathinfo($_FILES["uploadfile"]["name"][$i], PATHINFO_EXTENSION);
                $clean_extension = cleanExtensions($extension);
                $image_path = $originalfilename."_".$current_time.'.'.$clean_extension;
                $target_file = $target_dir . $image_path;
                $uploaded_filename = $target_file;

                
                // $path_parts['filename'].'_'.
    
                $uploadOk = 1;
               
    
                // Check if file already exists
                // if (file_exists($target_file)) {
                //     $error = "The file already exists.";
                //     $uploadOk = 0;
                // }
     
    
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
                    $error =  "Only JPG, JPEG, PNG & GIF files are allowed.<br>";
                    $uploadOk = 0;
                }
    
    
                // Check file size
                if ($_FILES["uploadfile"]["size"][$i] > 6000000) {
                    $error =  "Your file is too large.";
                    $uploadOk = 0;
                }
    
                if ($_FILES["uploadfile"]["size"][$i]==0) {
                    $error =  "Your file size was zero.";
                    $uploadOk = 0;
                }
    
    
    
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Your files were not uploaded.<br>";
                    echo $error;
                    $success = false;
    
                // if everything is ok, try to upload file  
                } else {
                  
                    // Let's find the artwork with the same title, and assign this new image to it
                    echo "<br>Looking for matching artwork object.<br>";
                    $found_id = 0;
                    $artwork = null;
                    $artwork = findArtwork_with_title(strtolower($originalfilename));
                    // echo "<br>Found: ";
                    // print_r($artwork);
                    // echo "<br>";
                    $foundImage = null;
                    if ($artwork) {
                        echo "<br>Found id: ".$artwork->id."<br>";
                        $found_id = $artwork->id;
                        $foundImage = null;
                        $foundImage = findImage($artwork->id);
                        echo "<br>Found image: ".$foundImage->id."<br>";
                    } else {
                        $artwork = new artworks(['']);
                        $artwork->title = ucfirst($originalfilename);
                        $artwork->width = 0; // we don't know the size of the actual canvas
                        $artwork->height = 0;
                        $artwork->get_created_dateObject_as_formatted_string();

                        $artwork->category = 'social';
                        $artwork->sold = 0;
                        $found_id = $artwork->save();
                        $foundImage = findImage($artwork->id);
                        echo "<br>Found image: ".$foundImage."<br>";
                    }

                    // only build a new image object if the found artwork didn't already have one.
                    if (!$foundImage) {
                        $image_info = getimagesize($_FILES["uploadfile"]["tmp_name"][$i]);
                        $newImage = null;
                        if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"][$i], $target_file)) {
                            $newImage = new Images( [0,0, $image_path, $image_info[0], $image_info[1] ] );
                            $newImage->artwork_id = $found_id;
                            
                            $newImage->save();
                        }
                    }
        }
 
        echo "<Br>";
    }


}


if ($_SERVER["REQUEST_METHOD"] == "POST") { 
         if (isset($_POST['submit']))
             { $error = analyzeNewInfo(); }
    
}




?>
<html>
    <body>
<div class='adminpage'><div class='logout'><a href='logout.php'>Log out</a></div>
			<a href='dashboard.php'><div class='backArrow'>Back to dashboard</div></a><br>
			
<div class='dash'>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src='js/date_picker.js'></script>
<script src='js/previewimages.js'></script>

<h1>Add multiple image files </h1>


<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "";?>" method='post' class='basicform group' enctype="multipart/form-data" >

<div class='chooseButton'>
<div class='fakeUploadImageButton'>Choose Image Files</div>
<input type="file" name="uploadfile[]" id="uploadfile" onchange="previewFiles()" multiple='multiple'><br clear='all'>
</div>
<div id='newImages'>
</div>





<br><br><a href='cancel_add_piece.php'>
<div class='cancel'>Cancel</div></a>
<button class='upload' type='submit' name='submit' id='submit' value='submit'>Upload these artworks</button>
<br clear='all'>
<br>

</form> 
</div></div>
</body>
</html>