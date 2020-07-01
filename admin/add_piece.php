<?php
//phpinfo();
// for some reason this class definition needs to get loaded in before the
// session start call ??
require_once '../classes/artworks.php';
require_once '../classes/images.php';
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once 'scripts/authorization.php';
include_once 'scripts/save.php';
include_once '../scripts/in_memory_functions.php';
include_once 'scripts/upload_image_file.php';
include_once '../classes/images.php';
include_once "../scripts/load.php"; 
authorize();

$today = date("Y-m-d H:i:s");


$width = '0';
$height = '0';
$file_error = null;
$error = [];
$newImage = null;
$uploadFile = null;
$temp = false;
$_SESSION['updated_artwork'] = null;

function handleImageUploadInfo() {
    $error = null;
    $_SESSION['updated_artwork'] = null;

    if (isset($_FILES) && $_FILES && $_FILES['uploadfile']['tmp_name']!=null) {
      //  echo "user chose a new image to upload.<br>";
        $error = check_image_file_for_upload_errors();

        if (count($error) < 1) {
          //  echo "no errors with image so far.";
            // upload the file -- and create the new imageObject -- but it is not yet saved
            $newImage = upload_image_file();  
           
            if ($newImage) {
             // echo "uploaded image.<br>";
  
              
              $_SESSION['newImage'] = $newImage;
              $_SESSION['tmpFile'] = $newImage->image_filename;
               // echo "setting tmpFile to: ".$_SESSION['tmpFile']."<br>";
            }
        } else {
            $_SESSION['tmpFile'] = $_FILES['uploadfile']['tmp_name'];
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

      
    }
    $title = '';
    $created = '';
    $width = '';
    $height = '';
    $category = '';
    $sold = 0;

    if (isset($_POST['title'])) {
      $title = $_POST['title'];
     // echo "<br>Title: ".$title."<br>";
      
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
     //   echo "<br>assigning category:" . $category."<br>";
    } 

    $sold = 0;

    if (isset($_POST['sold'] )) {
        $sold = 1;
    }

    $artwork = new artworks(['']);

    $artwork->title = escapeSingleQuotes($title);
   // echo "<br>escaped title: ".$artwork->title."<br>";
    $artwork->created = $created;
    $artwork->width = $width;
    $artwork->height = $height;
    $artwork->category = $category;
    $artwork->sold = $sold;

    $artwork->grab_form_for_piece_data();
    
    $info_errors = check_piece_form_for_errors(); 
    if ($info_errors) {
            $mergedArray =  array_merge($error_array, $info_errors);
            $error_array = $mergedArray;
  
    }
    $_SESSION['updated_artwork'] = $artwork;
    return $error_array;

}

function processPost() {

    $error = [];
    if ($_SERVER["REQUEST_METHOD"] == "POST") { 
         if (isset($_POST['submit']))
             { $error = analyzeNewInfo(); }
    
    if (!$error) {
        $artwork = $_SESSION['updated_artwork'];
        $new_id = $artwork->save();

        if ($new_id) {
            $image = $_SESSION['newImage'];
            $image->artwork_id = $new_id;
            $image->save();

          //echo "<br>Everything checked out ok!<br>";
            header("Location: dashboard.php");
        }
    }
    }
    return $error;
  
}

    $newwork = [ /*id*/ '0', 'title',$today, /*width*/'',/*height*/ '', /*category*/'', /*archived*/'', /*sold*/''];
    $artwork = new artworks($newwork);
        

    // we are proccessing a post request
    $error = processPost();
   // echo "<br>error variable is of type: ". gettype($error);

    if (isset($_SESSION['updated_artwork'])) {
        $artwork = $_SESSION['updated_artwork'];
    }

    if (count($error) > 0) {
    //   echo "<br>There were errors: <br>";
    //    foreach($error as $errorString) {
    //        print_r( $errorString."<br>" );
    //    }
    }

//echo "<br>error variable is of type: ". gettype($error);

include_once 'head.php';

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

<h1>Add a new piece</h1>


<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "";?>" method='post' class='basicform group' enctype="multipart/form-data" >

<?php 
//echo "tmpFile: " . $_SESSION['tmpFile']."|<br>";

if (!$_SESSION['tmpFile']) {
    ?>
<div class='fakeUploadImageButton'>Choose Image File</div>
<input type="file" name="uploadfile" id="uploadfile" onchange="previewFile()"><br clear='all'>
<?php if ($error && in_array('uploadfile',$error)) {
    echo "<div class='errorMsg includeImage'>Please include an image file to upload.</div>";
} ?>
<br>
<div id='newImages'>

<img class='previewImage' id='previewImage0'><br>
</div>
<?php } 
else {
    if ($_SESSION['newImage']) {
    echo "<img src='../uploads/artwork/".$_SESSION['newImage']->image_filename."' class='temp_image'>";
    } 
}
?>
<input type='hidden' name='artwork_id' id='artwork_id' value='<?php echo $artwork->id ?>'>

<div class='field'>
<label name='title' id='title'>Title:</label>

<?php 
    // echo "<input type='text' name='title' id='title' max-length='100' size='40' value='".htmlspecialchars($artwork->title)."'>";

    echo "<input type='text' name='title' id='title' max-length='100' size='40' value='";
    echo htmlspecialchars($artwork->title, ENT_QUOTES)."'>";
   


 ?>
</div>
<div class='field'>
<label name='title' id='title'>Created:</label>
<?php 
//echo $artwork->created_dateObject;
echo "<input type='text'  autocomplete='off' name='created' id='created' class='datepicker' value='".$artwork->created."'>";
?><br>
</div>
<div class='field'>
<div class='dimension'>
<label name='width' id='width'>Width:</label>
<?php if ($error && in_array('width', $error)) {
    echo "<input type='text'  autocomplete='off' size='5' max-length='50' name='width' class='errorfield' value='".$artwork->width."'> inches";
    echo "<div class='errorMsg'>Please include the width in inches.</div>";
} else {
echo "<input type='text'  autocomplete='off' size='5' max-length='50' name='width' value='".$artwork->width."'> inches";
}
?>

</div></div>
<div class='field'>
<div class='dimension'>
<label name='height' id='height'>Height:</label>
<?php if (count($error)>0 && in_array('height', $error)) {
echo "<input type='text' size='5'  autocomplete='off' max-length='50' name='height' class='errorfield' value='".$artwork->height."'> inches";
echo "<div class='errorMsg'>Please include the height in inches.</div>";
} else {
    echo "<input type='text'  autocomplete='off' size='5' max-length='50' name='height' value='".$artwork->height."'> inches";
}?>

</div></div>
<div class='field'>
<label>Category:</label>
<select name='category' id='category'>
<option value='social'>Social</option>
<option value='abstract'>Abstract</option>
<option value='figurative'>Figurative</option>
<option value='landscape'>Landscape</option>
</select>
</div>

<div class='field'>
    <label>Sold:</label>
    <input type="checkbox" name="sold" value="sold" <?php 
    if ($artwork->sold) { echo "checked";} ?> > This piece has already been sold<br>
</div>


<br><br><a href='cancel_add_piece.php'>
<div class='cancel'>Cancel</div></a>
<button class='upload' type='submit' name='submit' id='submit' value='submit'>Upload this artwork</button>
<br clear='all'>
<br>

</form> 
</div></div>
</body>
</html>