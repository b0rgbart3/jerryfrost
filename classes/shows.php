<?php
//    $root = $_SERVER['DOCUMENT_ROOT'];
//    echo "Doc Root: " . $root;
//    $current_level = dirname($_SERVER['SCRIPT_FILENAME']);
//    echo "<br>Current Level: " . $current_level;
//    $split = explode('/',$current_level);
//    $current_folder = $split[sizeof($split) -1];
//    echo "<br>Current Folder: " . $current_folder;

class shows {

    public function __construct($argArray) {

        date_default_timezone_set('America/Los_Angeles');
        $this->fieldnames = ['title','gallery','address','city','opening','closing','opening_start','opening_end','closing_start','closing_end', 'additional_notes', 'image_filename'];
        $this->labels = ['Show Title', 'Gallery / Venue', 'Address', 'City', 'Opening Date', 'Closing Date',
        'opening reception starts at', 'opening reception ends at', 'closing reception starts at', 'closing reception ends at', 'additional info', 'image filename'];
        $this->fields = [];
        $this->clearValues();
        
        $this->definition = "CREATE TABLE IF NOT EXISTS  `shows` ( `id` INT NOT NULL AUTO_INCREMENT , `title` VARCHAR(300) NULL, `gallery` VARCHAR(100) NULL, `address` VARCHAR(100) NULL, `city` VARCHAR(100) NULL,  `opening` VARCHAR(200) NULL,
        `closing` VARCHAR(200) NULL,
        `opening_start` VARCHAR(200) NULL,
        `opening_end` VARCHAR(200) NULL,
        `closing_start` VARCHAR(200) NULL,
        `closing_end` VARCHAR(200) NULL,
        `additional_notes` VARCHAR(200) NULL,
        `image_filename` VARCHAR(200) NULL,
        `entered` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,  PRIMARY KEY (id)); ";
       
        $this->id = 0;
        if ($argArray && (sizeof($argArray) > 1)) {
           
            foreach ($this->fieldnames as $index => $fieldname) {
                $this->fields[$fieldname] = $argArray[$index+1];  // skip the id for now
            }

            $this->id = $argArray[0];  // grab the id
        }

        // these are used in the add_show form to help us uplaod a new image;
        $this->temp = null;
        

    }

    function check_show_image_file_for_upload_errors() {
        $errors = [];
        $upload_error = false; 
        $target_dir = "../uploads/show_images";
        $originalfilename = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_FILENAME);
        $extension = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_EXTENSION);
        // Allow certain file formats
        if ($extension != "jpg" && $extension != "png" && $extension != "jpeg"
        && $extension != "gif" ) {
            array_push($errors,  "Only JPG, JPEG, PNG & GIF files are allowed.<br>" );
        }
        // Check file size
        if ($_FILES["uploadfile"]["size"] > 6000000) {  // Imagefile must be less than 6 megabytes
            array_push($errors, "Your file is too large."); }
    
        if ($_FILES["uploadfile"]["size"]==0) { array_push($error, "Your file size was zero.");}
        return $errors;
    }

    
    function upload_show_image_file() {
        $error = '';
    
        $target_dir = "../uploads/show_images/";
        $originalfilename = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_FILENAME);
        $current_time = time();
        $extension = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_EXTENSION);
        $image_path = $current_time.'.'. $extension;
        $target_file = $target_dir . $image_path;

        if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $target_file)) {
            $this->fields['image_filename'] = $image_path;
        } else {
                    echo "Sorry, there was an error uploading your file.";
                    $success = false;
                }       
    }
    

    function grabUploadImage() {
        $error = [];
        if ($_FILES['uploadfile']['tmp_name']==null) {
            array_push($error, 'uploadfile');
        }
        if ($_FILES['uploadfile']['tmp_name']!=null) {
            echo "chosen file is not null.";
            $error = $this->check_show_image_file_for_upload_errors();
            if (!$error) {
                
                $this->upload_show_image_file();
                echo "<br>uploaded image: ".$this->fields['image_filename']."<br>";
                if ($this->fields['image_filename']) {
                  $_SESSION['tmpFile'] = $_FILES['uploadfile'];
                 // $this->save();  
              }
            }                  
        }
    }
    function clearValues() {
        foreach ($this->fieldnames as $fieldname) {
            $this->fields[$fieldname] = '';
        }
    }

    function collectPostFields() {
        if ($_FILES['uploadfile']['tmp_name']!=null) {
          //  echo "<br>Grabbing new upload image.<br>";
          $this->grabUploadImage();
        } else {
           // echo "<br>No new upload image.</br>";
           // print_r($this->fields);
        }

        foreach ($this->fieldnames as $fieldname) {
           
            if ($fieldname != 'image_filename') { 
                if (isset($_POST[$fieldname])) {
            $this->fields[$fieldname] = $_POST[$fieldname]; } else {
                $this->fields[$fieldname] = '';
            } }
        }
        if ($this->fields['image_filename'] == '') {
            if (isset($_POST['image_filename'])) {
                $this->fields['image_filename'] = $_POST['image_filename'];
            }
        }
        if (isset($_POST['id'] )) {
            $this->id = $_POST['id'];
        }
    }

    function displayValues() {
        echo "<div class='showBox group'>";
        echo "<table><tr>";
      //  print_r($this->fields);
        foreach ($this->fieldnames as $index => $fieldname) {
            if ($fieldname != 'image_filename') {
                if ($this->fields[$fieldname] != '') {
            echo "<tr>";
            echo "<td class='show_label'>". $this->labels[$index]. ": </td>";
            
            if ($fieldname=='title') {
                echo "<td class='show_title'>";
            } else {
            echo "<td class='show_info'>";}
            
            echo  $this->fields[$fieldname]."</td>";
            echo "</tr>";
            } } else {
                echo "<div class='show_image'>";
                if ($this->fields['image_filename'] != '') {
                echo "<a href='uploads/show_images/".$this->fields['image_filename']."'>";
                echo "<img src='uploads/show_images/".$this->fields['image_filename']."'>";
                echo "</a>";
                }
                echo "</div>";
            }
        }
        echo "</table><br clear='all'>";
        echo "</div>";
    }

    function displayTimeFields($id) {
        echo "<label class='stronglabel'><span class='cap'>".$id."</span> reception:</label>";
        echo "<div class='field'>";
        echo "<label name='opening_start_time'>starts at:</label>";
        echo "<input type='text' name='".$id."_start' id='".$id."_start' class='time' value='".$this->fields[$id.'_start']."'>";
        echo "<br>";
        echo "</div>";
        echo "<div class='field'>";
        echo "<label name='opening_end_time'>ends at:</label>";
        echo "<input type='text' name='".$id."_end' id='".$id."_end' class='time' value='".$this->fields[$id.'_end']."'>";
        echo "<br>";
        echo "</div>";
    }

    function displayDateField($id) {
        echo "<div class='field'>";
        echo "<label>".$id.":</label>";
        echo "<input type='text' id='".$id."_date' name='".$id."_date' value='' class='datepicker'><br>";
        echo "</div>";
    }

    function displayFormFields($error) {
        if (!$_SESSION['tmpFile']) {
            if ($this->fields['image_filename']) {
                echo "<div id='newImages'>";
                echo "<img class='previewImage' src='../uploads/show_images/".$this->fields['image_filename']."' id='previewImage0'>";
                echo "</div>";
                echo "<div class='fakeUploadImageButton'>Upload New Image</div>";
                echo "<input type='file' name='uploadfile' id='uploadfile' onchange='previewFile()'><br clear='all'>";
                if ($error && in_array('uploadfile',$error)) {
                echo "<div class='errorMsg includeImage'>Please include an image file to upload.</  div>";
                } 
            } else {
                echo "<div class='fakeUploadImageButton'>Choose Image File</div>";
                echo "<input type='file' name='uploadfile' id='uploadfile' onchange='previewFile()'><br clear='all'>";
                if ($error && in_array('uploadfile',$error)) {
                echo "<div class='errorMsg includeImage'>Please include an image file to upload.</  div>";
                } 
                echo "<br>";
                echo "<div id='newImages'>";
                echo "<img class='previewImage' id='previewImage0'><br>";
                echo "</div>";
            }
        } 
        else {
            echo "<img src='../uploads/show_images/".$this->fields['image_filename']."' class='temp_image'>";
        }
        echo "<div class='field'>";
        echo "<label><span class='stronglabel'>Title of the show:</span></label>";
        echo "<input type='text' id='title' name='title' value='".$this->fields['title']."' size='40'>";
        echo "</div>";
        echo "";
        echo "<div class='field'>";
        echo "<label>Name of the gallery or venue:</label>";
        echo "<input type='text' id='gallery' name='gallery' value='".$this->fields['gallery']."' size='40'><br>";
        echo "</div>";
        echo "<div class='field'>";
        echo "<label>Address:</label>";
        echo "<input type='text' id='address' name='address' value='".$this->fields['address']."' size='40'><br>";
        echo "</div>";
        echo "<div class='field'>";
        echo "<label>City:</label>";
        echo "<input type='text' id='city' name='city' value='".$this->fields['city']."' size='40'><br>";
        echo "</div>";

    
        $this->displayDateField('opening');
        $this->displayDateField('closing');
        $this->displayTimeFields('opening');
        $this->displayTimeFields('closing');

        echo "<br><div class='field'>";
        echo "<label>Additional Notes:</label>";
        if ($this->fields && $this->fields['additional_notes']) {
        echo "<textarea id='additional_notes' name='additional_notes' cols='64' rows='8' >".$this->fields['additional_notes']."</textarea>"; } else {
            echo "<textarea id='additional_notes' name='additional_notes' cols='64' rows='8' ></textarea>";
        }
        echo "</div>";
        echo "<br><a href='dashboard.php'>
        <div class='cancel'>Cancel</div></a>
        <button class='upload' type='submit' name='submit' id='submit' value='submit'>Submit</button>
        <br clear='all'>
        <br>";


    }

    function save() {
        $db = $_SESSION['artwork_db'];
     
        $insertFields = '';
        foreach ($this->fieldnames as $fieldname) {
            $insertFields .= "`". $fieldname. "`,";

        }
        $insertFields = substr($insertFields, 0, -1);
        $insertValues='';
        foreach ($this->fieldnames as $fieldname) {
            $insertValues .= "'". $this->fields[$fieldname]. "',";
        }
        $insertValues = substr($insertValues, 0, -1);
        $sqlInsert = "INSERT INTO `shows` ( ".$insertFields." ) VALUES ( ". $insertValues." );";

        $result = $db->query( $sqlInsert);
    
        if (!$result) {
            echo "error saving the show to the database.";
            echo "<br>";
            echo $sqlInsert;
            echo "<br><br>";
            $newid = 0;
        } else {
            $newid = $db->insert_id;
    
        }
        
        return $newid; 
    }

    function update() {
        $db = $_SESSION['artwork_db'];

        $sqlInsert = "UPDATE `shows` SET ";
        foreach ($this->fieldnames as $fieldname) {
            $sqlInsert .= "`".$fieldname."`= '".$this->fields[$fieldname]."',";
        }
        $sqlInsert = substr($sqlInsert,0,-1);
        $sqlInsert .= " WHERE `id`='".$this->id."';";
    
       // echo $sqlInsert;
        $result = mysqli_query($db, $sqlInsert);
    
        if (!$result) {
            echo "<BR> error updating the artwork in the database.";
           // echo $sqlInsert;
        } 
        
    }

    function admin_tableOutput() {

      
        echo "<div class='adminShowInfo group'  data-id='".$this->id."'>";
        if ($this->fields['image_filename'] != '') {
        echo "<div class='adminShowimage'>";
       
        echo "<img src=../uploads/show_images/".$this->fields['image_filename'].">";
        
        echo "</div>";
        }
        echo "<div class='adminShowTextInfo group'>";
        // echo "<div class='adminFunctions'>";
        echo "<div class='action remove_show' data-action='remove_show' data-id='".$this->id."'></div>";
       
   
        // echo "<div class='action' data-action='edit_show' data-id='".$this->id."'>Edit show info</div>";
        
        foreach ($this->fieldnames as $fieldname) {
         
            
            if ($fieldname != 'image_filename') {
                
             echo "<div class='adminShowText group'>";
             echo "<div class='adminShowLabel'>". $fieldname. ":</div>";
             echo "<div class='adminShowValue'>". $this->fields[$fieldname]."</div>";
             echo "</div>";
            }
        }
        echo "<p data-action='edit_show' class='editshow' data-id='".$this->id."'>Edit</p>";
        echo "</div>";
        // echo "</div>";
        echo "</div>";

    
    }

}
