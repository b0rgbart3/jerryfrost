<?php
//phpinfo();
// for some reason this class definition needs to get loaded in before the
// session start call ??
require_once '../classes/artworks.php';
require_once '../classes/images.php';
include_once '../classes/shows.php';
session_start();
include_once 'scripts/authorization.php';
include_once 'scripts/save.php';
include_once '../scripts/in_memory_functions.php';
include_once 'scripts/upload_image_file.php';
//include_once '../classes/images.php';

authorize();
include_once 'head.php';

$errors = [];

if (isset($_GET['id']) ) {
    // If we just got to this edit page, the id will be in the url
    $existingID = $_GET['id']; 
    $show= findShow($existingID);
   // print_r($show->fields);
    $show->id = $existingID;
   // echo "SHOW ID: " . $show->id;
} else {
    $show = new shows(['']);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    if (isset($_POST['submit']))
    {
        $show->collectPostFields();
        $_SESSION['show'] = $show;
        //$show->displayValues();
        if ($show->fields['title'] != '') {
          //  print_r($show->fields);
            $show->update();

            header("Location: dashboard.php");
        }
    }
} 

$refer = $_SERVER['HTTP_REFERER'];
//echo $refer;
//header("Location: ".$refer);


?>


    <body>
<div class='adminpage'><div class='logout'><a href='logout.php'>Log out</a></div>

<a href=<?php echo $refer; ?>><div class='backArrow'>Back to dashboard</div></a><br>
			
<div class='dash'>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src='js/date_picker.js'></script>
<script type="text/javascript" src="js/jquery.timepicker.js"></script>
<script src='js/previewimages.js'></script>


<h1>Edit show info:</h1>


<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "";?>" method='post' class='basicform group' enctype="multipart/form-data" >
<?php if ($show) { $show->displayFormFields($errors); } ?>

<input type='hidden' name='id' id='id' value=<?php echo "'".$show->id."'"; ?>>
<input type='hidden' name='image_filename' id='image_filename' value=<?php echo "'".$show->fields['image_filename']."'"; ?>>
</form>
<script>
    $(function() {
                $('#opening_start').timepicker();
                $('#opening_end').timepicker();
                $('#closing_start').timepicker();
                $('#closing_end').timepicker();
			});
    </script>
</body>
</html>