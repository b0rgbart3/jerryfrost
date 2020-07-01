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
$show = new shows(['']);
$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    if (isset($_POST['submit']))
    {
        
        $error = $show->collectPostFields();
        $_SESSION['show'] = $show;
        $show->displayValues();
        if ($show->fields['title'] != '') {
            $show->save();
            header("Location: dashboard.php");
        }
    }
} else {
    $show = new shows(['']);
}

?>


    <body>
<div class='adminpage'><div class='logout'><a href='logout.php'>Log out</a></div>
			<a href='dashboard.php'><div class='backArrow'>Back to dashboard</div></a><br>
			
<div class='dash'>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src='js/date_picker.js'></script>
<script type="text/javascript" src="js/jquery.timepicker.js"></script>
<script src='js/previewimages.js'></script>


<h1>Add a new show</h1>


<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "";?>" method='post' class='basicform group' enctype="multipart/form-data" >


<?php if ($show) { $show->displayFormFields($error); } ?>

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