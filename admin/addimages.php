<!-- <?php
//phpinfo();
// for some reason this class definition needs to get loaded in before the
// session start call ??
// require_once '../classes/artworks.php';
// require_once '../classes/images.php';
// session_start();
// include_once 'scripts/authorization.php';
// include_once 'scripts/save.php';
// include_once '../scripts/in_memory_functions.php';

// authorize();
// include_once 'head.php';
// if (isset($_GET['id'])) {
//     $id = $_GET['id'];
//     $artwork = findArtwork($id);
// }
// if ($_SERVER["REQUEST_METHOD"] == "POST") { 
//     if (isset($_POST['submit']))
    // {
    //     $success = true;  // to start with

    //    // upload the image(s) and attach them to the artwork in question

    //    $artwork_id= $_POST['artwork_id'];

    //    $upload_error = false; 
    //    $imageCount = count($_FILES["files"]["name"]);

    //   // print_r($_FILES["files"]);
    //   //  echo "<br>";
    //   //  echo "Number of images: ".$imageCount."<br>";

    //     $imageArray = [];
    //     $imageWidths = [];
    //     $imageHeights = [];
    

       for ($i = 0; $i < $imageCount; $i++) {

            $target_dir = "../uploads/artwork/";
            $path_parts = pathinfo($_FILES["files"]["name"][$i]);
            $current_time = time() + $i;

            $image_path = $current_time.'.'.$path_parts['extension'];
            //$target_file = $target_dir . basename($_FILES["files"]["name"][$i]);
            $target_file = $target_dir . $image_path;
            $uploaded_filename = $target_file;
            
            // $path_parts['filename'].'_'.

            $uploadOk = 1;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            

            // Check if file already exists
            if (file_exists($target_file)) {
                $error = "The file already exists.";
                $uploadOk = 0;
            }
 

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
                $error =  "Only JPG, JPEG, PNG & GIF files are allowed.<br>";
                $uploadOk = 0;
            }


            // Check file size
            if ($_FILES["files"]["size"][$i] > 6000000) {
                $error =  "Your file is too large.";
                $uploadOk = 0;
            }

            if ($_FILES["files"]["size"][$i]==0) {
                $error =  "Your file size was zero.";
                $uploadOk = 0;
            }



            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Your file was not uploaded.<br>";
                echo $error;
                $success = false;

            // if everything is ok, try to upload file  
            } else {
               // echo "<br>Trying to upload: ".$_FILES["files"]["tmp_name"][$i]."<br>";
                $image_info = getimagesize($_FILES["files"]["tmp_name"][$i]);

                if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $target_file)) {
                    
                    
                    $thisImageWidth = $image_info[0];
                  //  echo "Image Width:" . $thisImageWidth;
                    $thisImageHeight = $image_info[1];
                  //  echo "Image Height:" . $thisImageHeight;

                    array_push($imageArray, $image_path);
                    array_push($imageWidths, $thisImageWidth );
                    array_push($imageHeights, $thisImageHeight );
                    
                    
                    //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                    $success = false;
                }
            } // end of else


        } // end of for loop

        echo "About to check success: " . $success."<BR>";
        if ($success) {
            $artwork_id = $_POST['artwork_id'];
            echo "Inside the sucess section.<br>";

           // echo "<p>SUCCESS</p>";
            
           
            // Create an image object for each of the uploaded images,
            // and then "save" their info in the DB

            for ($j = 0; $j < count($imageArray); $j++) {            
              $newImage = new images(['0', $artwork_id, $imageArray[$j], $imageWidths[$j], $imageHeights[$j]]);

              $result_from_saving = $newImage->save();
              echo "<br>The Result from saving: <br>";
              echo $result_from_saving;
              echo "<br>";
            }
           // header("Location: dashboard.php");
            print_r($imageArray);

        }
    }  //end of submit
} // end of post


?>

<script src='js/previewimages.js'></script>


<a href='index.php'>&#x21a4; Back to the dashboard</a><br>

<?php 
 if (isset($_POST['submit']) && !$success ) {

 } else {
?>

<h1>Add a new images</h1>
<!-- <img src="images/noimage.png" id='previewImage'><br><br> -->



<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "";?>" method='post' class='basicform group' enctype="multipart/form-data" >

<?php 
// $artwork = findArtwork($id);
echo "<h1>Title: ".$artwork->title."</h1>";
?>
<br>



<!--
<h1>Add a new image</h1>
<p>To upload a new image:</p>
 <p>
	1) first click 'choose file' to select it from the filesystem.<p>
	<p>2) Then click 'upload' to add it to the website.</p>
-->


 
    <input type="file" name="files[]" id="files" onchange="previewFile()" multiple='multiple'><br>
    <div id='newImages'>
</div>
<input type='hidden' name='artwork_id' id='artwork_id' value='<?php echo $artwork->id ?>'>
    <button type="submit" value="Upload Image" name="submit" id='upload'>Upload</button>

</form> 

<?php 


 }


?> -->
