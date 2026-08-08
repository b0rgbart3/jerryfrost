<?php
?>
<html>
<meta charset = "UTF-8" name="viewport" content="initial-scale=1.0, user-scalable=1">
<html lang="en">
<head>
<title>Artist: Jerry Frost</title>
<script src='js/previewimages.js'></script>
<link rel="stylesheet" type="text/css" href="css/basics.css" />
<link rel="stylesheet" type="text/css" href="css/review.css" />
<script src='js/review.js'></script>
<script src='js/loadjson.js'></script>
<script src='js/group.js'></script>

</head>
<body>
    <h1>Review the catalog:</h1>
    <a href="index.php">Home</a> |     <a href='logout.php'>Logout</a> |
    <a href="upload.php">Add a new painting</a>
    <!-- |&nbsp;<a href="reviewchart.php">Full Chart</a> -->
    <br>

    <ul class='sortFilters'><li onClick=sortByEntered()>Sort by date entered</li><li onClick=sortByDate()>Sort by date of painting</li></ul>
    <div class="reviewer">
        <div id="image-gallery" class="image-gallery">
        </div>

    </div>
    <div id="editor" class="editor">
        <img id="painting" class="editorPainting">
        <div class='info hidden' id='info'>
          <div class='theTitle' id='pTitle'></div>
          <div class='theSize' id='theSize'>
              <span id='pWidth'></span>'' X <span id='pHeight'></span>''<br>
          </div>
          <div class='theDate'>
          <div class='theMonth' id='pMonth'>Month:</div>&nbsp;
          <div class='theDay' id='pDay'>Day:</div>,&nbsp;
          <div class='theYear' id='pYear'></div>
</div>
          
        </div>
        <button class='hidden' id='editInfo' onclick='editThisInfo(this)'>Edit this Info</button>
        <?php
        // echo "<form action='". htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post' class='inputForm hidden' id='inputForm' >";
        ?>
        <form action="save_or_remove.php" method="post" class="inputForm hidden" id="inputForm">
            <div class='inputItem'>
              <label name='title'>Title:</label>
              <input type='text' name='inputTitle' id="inputTitle" size='24'></input>
            </div>
            <div class='inputItem'><label name='width'>Width:</label>
              <input type='text' name='inputWidth' id='inputWidth' size='5'></input>
              <label name='height' >Height:</label>
              <input type='text' name='inputHeight' id='inputHeight' size='5'></input>
              <span class='unit'>(inches)</span><br/>
              <br>
            </div>

            <label name='monthpainted'>Month painted:</label>
            <select id="monthSelect" name="monthSelect">Month</select>
                <br/>
            <br>

            <label name='day painted'>Day painted:</label>
            <select id="daySelect" name="daySelect"></select><br/>


            <label name='year painted'>Year painted:</label>
            <select id="yearSelect" name="yearSelect"></select><br/>

            <div>
            <p class='labelTitle'>Categories:</p>
            <div id="categoryBoxes">
     
            </div>
            </div>
            <p class='labelTitle'>Is this painting already sold:</p>
            <label name='sold'>Sold:</label>
            <input type="checkbox" name='sold' id='sold'/>
            <br><br/>
        
           <input type='text' name='inputId' id='inputId' class='hidden'></input><br/>
            <input type='submit' value='SAVE THESE CHANGES' class='jSubmit' name='submit_button'></input><br><br>
            <br>
            <input type='submit' value='REMOVE THIS PAINTING' class='jSubmitDangerous' name='submit_button'></input>
        </form>
    </div>

</body>
</html>