<?php
?>
<html>
<meta charset = "UTF-8" name="viewport" content="initial-scale=1.0, user-scalable=1">
<html lang="en">
<head>
<title>Artist: Jerry Frost</title>
<script src='js/previewimages.js'></script>
<link rel="stylesheet" type="text/css" href="css/basics.css" />
<link rel="stylesheet" type="text/css" href="css/reviewchart.css" />
<script src='js/reviewchart.js'></script>
<script src='js/loadjson.js'></script>
<script src='js/group.js'></script>
<script>
    function validateForm() {
     
        let changesToSubmit = [];
        for (var i = 0; i < paintings.length; i++) {
            
            const title = document.getElementById('imgInputTitle-' + i);
            const sold = document.getElementById('imgInputSold-' + i);
            
            if (title) {
                const titleValue = title.value;
                if (titleValue !== paintings[i].title) {
                  changesToSubmit.push(i)
                }
            }

            if (sold) {
                const soldValue = sold.checked;
                if (soldValue !== paintings[i].sold) {
                    // console.log('Painting # ', i, ' sold status got changed to: ', soldValue);
                    if (!changesToSubmit.includes(i)) {
                        changesToSubmit.push(i)
                    }
                
                }
            }
    

        }
       
        if (changesToSubmit.length > 9) {
            alert('We are sorry but you can only make up to 250 changes at a time.');
            return false;
        }
        else {
        for (var i = 0; i < paintings.length; i++) {
            if (!changesToSubmit.includes(i)) {
                const input = document.getElementById('imageInputDiv-' + i);
                if (input) {
                    input.remove()
                }
            }
        }
        
        const counter = document.getElementById('imgCount');
        const stringVersion = JSON.stringify(changesToSubmit);
        counter.value = stringVersion;
        
        console.log(stringVersion);
        console.log(typeof stringVersion);
      
      }
    
    }
    </script>
</head>
<body>
    <h1>Chart of paintings:</h1>
    <a href="index.php">Home</a> |     <a href='logout.php'>Logout</a> |
    <a href="upload.php">Add a new painting</a>|
    <a href="review.php">Single Entries</a><br>

    <ul class='sortFilters'><li onClick=sortByEntered()>Sort by date entered</li><li onClick=sortByDate()>Sort by date of painting</li></ul>
    <div class="reviewer">
        <div id="image-gallery" class="image-gallery">
            <form action='processchart.php' id='chartForm' method="post" onsubmit="return validateForm()">

            <input type='hidden' value='3' name='imgCount' id='imgCount'>
            <input type='submit' value='SAVE THESE CHANGES' class='jSubmit' name='submit_button'></input><br><br>

            </form>
        </div>

    </div>


          
       
    </div>

</body>
</html>