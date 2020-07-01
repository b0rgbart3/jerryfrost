<?php
require_once '../classes/artworks.php';
session_start();
include_once '../config.php';
include_once 'scripts/authorization.php';
include_once 'scripts/save.php';
include_once '../scripts/in_memory_functions.php';
include_once '../classes/images.php';
include_once 'scripts/upload_image_file.php';
include_once "../scripts/load.php"; 
authorize();

function handleImageUploadInfo() {
    $error = false;
    $_SESSION['updated_artwork'] = null;

    if ($_FILES['uploadfile']['tmp_name']!=null) {
      //  echo "user chose a new image to upload.<br>";
        $error = check_image_file_for_upload_errors('');
        if (!$error) {
            
            //If the new image checks out for uploadability - then we can go ahead and remove the old image
            $existingID = $_POST['existingID'];
           // echo "existing ID:".$existingID;

            $artwork = findArtwork($existingID);
          //  echo "<br>Artwork:";
          //  print_r($artwork);

            $old_image = findImage($artwork->id);
            
          //  echo "<Br>Old Image: ";
           // print_r($old_image);

            if ($old_image) { $old_image->delete();}


            // upload the file -- and create the new imageObject -- but it is not yet saved
            $newImage = upload_image_file();  
           
            if ($newImage) {
         //     echo "uploaded image.<br>";
              $newImage->artwork_id = $artwork->id;
              // now that we have inserted the artwork id, we can save the image object
              $result_from_saving = $newImage->save();
        //      echo "saved image object, with an id of ".$result_from_saving."<br>";
              $newImage->id = $result_from_saving;
              
              $_SESSION['newImage'] = $newImage;
              $_SESSION['tmpFile'] = $_FILES['uploadfile'];
              $_SESSION['updated_artwork'] = $artwork;
            }
        }
    }
    return $error;
}                  
       

function analyzeNewInfo() {
   // echo "Got a new post.<br>";
    //print_r( $_FILES );
    $error = handleImageUploadInfo();
    
    // If the user uploaded a new image and there were no errors, it will be stored in this session var.
    if (isset($_SESSION['updated_artwork'])) {
        $artwork = $_SESSION['updated_artwork'];
    } else {
      $existingID = $_POST['existingID'];
      $artwork = findArtwork($existingID);
    }

    if (isset($_POST['title'])) {
      $title = $_POST['title'];
   //   echo "<br>Title: ".$title."<br>";
      
    }

    if (isset($_POST['created'])) {
        // We need to convert the date form the human readable version to a db friendly version.
        $created = $_POST['created'];
        $middle = strtotime($created); 
        $newCreated =  date('Y-m-d H:i:s',$middle);
        $created = $newCreated;
       
    }

    if (isset($_POST['width'])) {
    $width = $_POST['width']; }
    if (isset($_POST['height'])) {
    $height = $_POST['height']; }
    
    if (isset($_POST['category'])) {  
        $category = $_POST['category'];
      //  echo "<br>assigning category:" . $category."<br>";
    } 

    $sold = 0;

    if (isset($_POST['sold'] )) {
        $sold = 1;
    }

    if ($title == null || $title=='') {
        $error = 'title';
    } 

    //$artwork->title = escapeSingleQuotes($title);
    //$artwork->title = escapeSingleQuotes($title);
    $artwork->title = $title;
    //echo "<br>escaped title: ".$artwork->title."<br>";

    $artwork->created = $created;
   // echo $artwork->created;
   // echo "<br>".$artwork->get_created_dateObject_as_formatted_string();
    $artwork->width = $width;
    $artwork->height = $height;
    $artwork->category = $category;
    $artwork->sold = $sold;

    $_SESSION['updated_artwork'] = $artwork;
    return $error;

}

function processPost() {

    $error = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST") { 
         if (isset($_POST['submit']))
             { $error = analyzeNewInfo(); }
    }
    if (!$error) {
        $artwork = $_SESSION['updated_artwork'];
        $success = $artwork->update();

        if ($success) {
       //   echo "<br>Everything checked out ok!<br>";
            header("Location: dashboard.php");
        }
    }

    return $error;
  
}
    
$refer = $_SERVER['HTTP_REFERER'];
 $error = null;
 $submitted = false;
 $width = '0';
 $height = '0';
 $depth = '0';
 $weight = '0';
 $media = '';
 $description = '';

if (isset($_GET['id']) ) {
    // If we just got to this edit page, the id will be in the url
    $existingID = $_GET['id']; 
    $artwork= findArtwork($existingID);
    $image = findImage($artwork->id);
} else {
    // we are proccessing a post request
    $error = processPost();
    $artwork =  $_SESSION['updated_artwork'];  // grab the artwork object from the session
    $image = findImage($artwork->id);
    $existingID = $artwork->id;
}

include_once 'head.php';
?>

<html>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src='js/date_picker.js'></script>
<script src='js/previewimages.js'></script>

<body>
<div class='adminpage'><div class='logout'><a href='logout.php'>Log out</a></div>
<a href=<?php echo $refer; ?>><div class='backArrow'>Back to dashboard</div></a><br>	
<div class='dash'>
<h1>Edit artwork</h1> 
<?php echo "<div class='programmer_text'>artwork id: ". $existingID. "</div>"; ?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "";?>" method='post' class='basicform newart group' enctype="multipart/form-data">
<div id = 'newImages'>
<?php 
if ($image && $image->image_filename) {
    echo "<img src='../uploads/artwork/".$image->image_filename."' class='editthumb'>";
} else {
    echo "<br>missing image file<br>";
}?>
</div>

<br clear='all'>
<div class='fakeUploadImageButton'>Upload New Image</div>
<input type="file" name="uploadfile" id="uploadfile" onchange="previewFile()"><br clear='all'>



<input type='hidden' name='existingID' id='existingID' value='<?php echo $existingID; ?>'>
<div class='field'>
<label name='title' id='title'>Title:</label>
<?php if ($error && $error=='title') {
    echo '<input type="text" name="title" id="title" max-length="100" size="40" class="errorfield">';
    echo '<p class="error_message">Please include a title.</p>';
} else {
    echo '<input type="text" name="title" id="title" max-length="100"  autocomplete="off" size="40"';
    echo ' value="'.$artwork->title.'">';
} ?>
</div>
<div class='field'>
<label value='<?php echo $artwork->title; ?>'>Created:</label>
<?php 
  echo "<input type='text' name='created' id='created' class='datepicker' autocomplete='off'
  value='".$artwork->created."'>";
?>
</div>
<div class='field'>
<label name='width' id='width'>Width:</label>
<input type='text' name='width' id='width' size='5' max-length='50'  autocomplete='off' <?php echo "value='".$artwork->width."'"; ?>> inches
</div>
<div class='field'>
<label name='height' id='height'>Height:</label>
<input type='text' name='height' id='height' size='5' max-length='50'  autocomplete='off' <?php echo "value='".$artwork->height."'"; ?> > inches
</div>


<div class='field'>
<label>Category:</label>
<select name='category' id='category'>
    <option value='social' <?php if ($artwork->category == "social") { echo "selected"; } ?>>Social</option>
        <option value='abstract' <?php if ($artwork->category == "abstract") { echo "selected"; } ?> >Abstract</option>
        <option value='figurative' <?php if ($artwork->category == "figurative") { echo "selected"; } ?>  >Figurative</option>
        <option value='landscape' <?php if ($artwork->category == "landscape") { echo "selected"; } ?>  >Landscape</option>

    </select>
</div>


<div class='field'>
    <label>Sold:</label>
    <input type="checkbox" name="sold" value="sold" <?php 
    if ($artwork->sold) { echo "checked";} ?> > <span class='noselect'>This piece has already been sold</span><br>
</div>


<br clear='all'>
<br>
<button type='submit' name='submit' id='submit' value='submit' class='upload'>Submit Changes</button>
<a href='dashboard.php'>
<div class='cancel'>Cancel</div></a>
<br clear='all'>
<br>
</form>



</div>
</div>
</body>
</html>