<?php

/* This is the Artworks object class definition
*/
   

class images {


    public function __construct($argArray) {

//        print_r($argArray);

        date_default_timezone_set('America/Los_Angeles');
        $this->id = $argArray[0];
        $this->artwork_id = $argArray[1];
        $this->image_filename = $argArray[2];
        $this->width = $argArray[3];
        $this->height = $argArray[4];
        if ($this->width >= $this->height) {
        $this->orientation = 'landscape';
        } else {
            $this->orientation = 'portrait';
        }
        $this->definition = "CREATE TABLE IF NOT EXISTS  `images` ( `id` INT NOT NULL AUTO_INCREMENT , `artwork_id` INT NOT NULL, `image_filename` VARCHAR(200) NULL, `width` INT NOT NULL, `height` INT NOT NULL, `orientation` VARCHAR(200)NULL, `entered` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,  PRIMARY KEY (id)); ";
        $this->saved = false;
       

    }

    function output() {
        echo "<p>ID: ".$this->id."</p>";
        echo "<p>Artwork_ID: ".$this->artwork_id."</p>";
        echo "<p>Image Filename: ".$this->image_filename."</p>";
        
    }

    function tableOutput() {
        echo "<tr>";
        echo "<td>".$this->id."</td>";
        echo "<td>".$this->artwork_id."</td>";
        echo "<td>".$this->image_filename."</td>";
        echo "</tr>";
    }

    // save directly to the db from the class... imagine that!
    
    function save() {
        $db = $_SESSION['artwork_db'];
        //save_image($this, $db);
           
        $sqlInsert = "INSERT INTO `images` ( `artwork_id`, `image_filename`, `width`, `height`, `orientation`) VALUES ( '".$this->artwork_id."', '".$this->image_filename."', '".$this->width."', '".$this->height."', '".$this->orientation."' );";
    
        $result = mysqli_query($db, $sqlInsert);
        
        $this->id= $db->insert_id;
        $this->saved = true;

        $newid = $db->insert_id;
        $this->id = $newid;

        return $newid;    
       

    }

    function delete() {
       // echo 'deleting this image.<br>';
        $db = $_SESSION['artwork_db'];
        $sql = "DELETE FROM `images` WHERE `id` = '".$this->id."';";
       // echo "SQL: ".$sql."<BR>";
        $result = mysqli_query($db, $sql);

        unlink("../uploads/artwork/".$this->image_filename);
        unlink("../uploads/thumbs/".$this->image_filename);
    }

    function update() {
        $db = $_SESSION['artwork_db'];

       // echo "updating image... ";
       // print_r($this);

        $sqlInsert = "UPDATE `images` SET `artwork_id`='".$this->artwork_id."', `image_filename`='".$this->image_filename."', `width`='".$this->width."', `height`='".$this->height."', `orientation`='".$this->orientation."' WHERE `id`=".$this->id;
    
        $result = mysqli_query($db, $sqlInsert);
    
        if (!$result) {
            echo "error updating the image in the database.";
            echo $sqlInsert;
        } 
        
    }

}

?>
