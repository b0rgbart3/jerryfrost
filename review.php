<?php
/// ini_set('session.save_path', '../sessions'); // Adjust the path if needed
session_start();
$logged_in = $_SESSION['logged_in'];

if (!$logged_in) {
   header("Location: ./login/"); /* Redirect browser */
}

?>
<html>
<meta charset = "UTF-8" name="viewport" content="initial-scale=1.0, user-scalable=1">
<html lang="en">
<head>
<title>Artist: Jerry Frost</title>
<script src='js/previewimages.js'></script>
<link rel="stylesheet" type="text/css" href="css/basics.css" />
<link rel="stylesheet" type="text/css" href="css/review.css" />
<script src='js/group.js'></script>
<script src='js/review.js'></script>
<script src='js/loadjson.js'></script>


</head>
<body class='admin'>
<a href='index.php'><div class='backContainer'><div class='goBack'><img src='interface/backArrow.svg'></div><div class='goBackText'>Go Back Home</div></div></a>
<div class='bigButtons'><a href="upload.php">Add a new painting</a></div>
    <div id='categorySelector' class='categoryMenu'></div>
         
    <ul class='sortFilters'>SORT BY: <li onClick=sortByDate(event) class='sortFiltersLi chosen'>painting date</li><li onClick=sortByEntered(event)  class='sortFiltersLi'>upload date</li></ul>
    <div class="reviewer">
        <div id="image-gallery" class="image-gallery">
        </div>

    </div>
    <div id="editor" class="editor hiddenEditor">
    <div class='closeButton' onclick='closeEditor()'></div>
        <div class='editorFrame'>
            <img id="painting" class="editorPainting"><div class='editorPaintingSold' id='editorPaintingSold'></div></div>
        
        <div class='info hidden' id='info'>
            <div class='infoBox'>
          <div class='theTitle' id='pTitle'></div>
          <div class='theSize' id='theSize'>
              <span id='pWidth'></span>'' X <span id='pHeight'></span>''<br>
          </div>
          <div class='theDateContainer'>
            <div class='theDate'>
            <div class='theMonth' id='pMonth'>Month:</div>&nbsp;
            <div class='theDay' id='pDay'>Day:</div>,&nbsp;
            <div class='theYear' id='pYear'></div>
           </div>
         </div>
         <div class='edCatList' id='edCatList'>

         
        </div></div><br>   
        <button class='loginButton hidden' id='editInfo' onclick='editThisInfo(this)'>Edit this Info</button> 
    </div>
 

        <form action="save_or_remove.php" method="post" class="inputForm hidden" id="inputForm">
            <div class='editorClose'> <div class='closeButton' onclick='stopEditing()'></div></div>
            <div class='inputItem'>
              <label name='title' class='inputLabel'>Title:</label>
              <input type='text' name='inputTitle' id="inputTitle" size='24'></input>
            </div>
            <div class='inputItem'><label name='width'  class='inputLabel'>Width:</label>
              <input type='text' name='inputWidth' id='inputWidth' size='5'></input>
              <label name='height'  class='inputLabel'>Height:</label>
              <input type='text' name='inputHeight' id='inputHeight' size='5'></input>
              <span class='unit inputLabel'>(inches)</span><br/>
              <br>
            </div>

            <label name='monthpainted' class='inputLabel'>DATE PAINTED:</label>
            <select id="monthSelect" name="monthSelect">Month</select>
            <select id="daySelect" name="daySelect"></select>
            <select id="yearSelect" name="yearSelect"></select>

            <div>
            <p class='inputLabel'>Categories:</p>
            <div id="categoryBoxes" class='categoryBoxes'>
     
            </div>
            </div>


            <input type="checkbox" name='sold' id='sold' class='bigCheck'/>
            <label class='inputLabel' name='sold'>Sold</label>
            <p class='labelTitle hintText'> ( If marked as sold, it won't display on the website. )</p>
            <br>
        
           <input type='text' name='inputId' id='inputId' class='hidden'></input>
            <input type='submit' value='SAVE THESE CHANGES' class='jSubmit' name='submit_button'></input>
             <!-- jSubmitDangerous -->
            <div class='trashWrapper'>
            <input type='submit' value='REMOVE THIS PAINTING' class='trash' name='submit_button' title='DELETE THIS PAINTING'></input>
           </div>
        </form>
    </div>  
    <a href='logout.php' id='logoutButton'>Logout</a>
</body>
</html>