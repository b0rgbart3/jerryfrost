<?php
include_once 'images.php';
/* This is the Artworks object class definition
*/
   

class artworks {

    private $definition;

    public function __construct($argArray) {

//        print_r($argArray);

        date_default_timezone_set('America/Los_Angeles');
        $this->id = $argArray[0];
        $this->title = '';
        if (isset($argArray[1])) {
        $this->title = $argArray[1]; } 
        $this->created = null;
        if (isset($argArray[2])) {
        $this->created = $argArray[2]; }
        if (isset($argArray[2])) {
            $this->createdDateTime = strtotime($argArray[2]); 
        }
        $this->width = null;
        if (isset($argArray[3])) {
        $this->width = $argArray[3]; }
        $this->height = 0;
        if (isset($argArray[4])) {
        $this->height = $argArray[4]; }
        $this->category = '';
        if (isset($argArray[5])) {
            $this->category = $argArray[5];
        }
        $this->sold = 0;
        if (isset($argArray[6])) {
            $this->sold = $argArray[6];
        }
        $this->archived = 0;
        if (isset($argArray[7])) {
            $this->archived = $argArray[7]; 
        }
        if (isset($argArray[8])) {
            $this->entered = $argArray[8]; 
        }

        
        date_default_timezone_set('America/Los_Angeles');
        $format = 'Y-m-d H:i:s';
        if ($this->created) {
        $this->created_dateObject = DateTime::createFromFormat($format, $this->created); } else {
           // echo "creating new date object<br><br>";
            $this->created_dateObject = time();
            
        }
        $this->image_id = null;

        $this->definition = "CREATE TABLE IF NOT EXISTS  `artworks` ( `id` INT NOT NULL AUTO_INCREMENT , `title` VARCHAR(300) NULL, `created` DATETIME NULL, `width` VARCHAR(100) NULL, `height` VARCHAR(100) NULL,  `category` VARCHAR(200) NULL, `sold` BOOLEAN DEFAULT FALSE,  `archived` BOOLEAN DEFAULT FALSE, `entered` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,  PRIMARY KEY (id)); ";
        $this->images = [];
        $this->loadImages();

    }


    function isCurrent() {
        $current = false;
        $this->get_created_dateObject();
        $currentTime = time();

        $currentYear = date("Y", $currentTime);
        $artworkYear = date("Y", $this->createdDateTime);

        if (($currentYear - $artworkYear) < 4) {
           // echo "current piece<br>";
            $current= true;
        }

        //echo "Current Year: ".$currentYear.", and created Year: ".$artworkYear."<br>";
       // echo "Current Date: ". date("Y-m-d", $currentTime ). "<br>";  // Y-m-d H:i:s

        //echo "Created Date: " . date("Y-m-d", $this->createdDateTime )."<br>";
       // echo "Creation Time: ". date_format("Y-m-d H:i:s", $this->createdDateTime );
        //$creation_date = strtotime($this->created);

       // $creation_date = date("Y-m-d H:i:s", $this->created);

       // echo $creation_date;
       // $diff = $currentTime - $creation_date;
        
        //echo $creation_date."<br>";
        //echo date_format($creation_date, 'Y-m-d H:i:s');
        //$year = $creation_date/365/24/60/60;
        //$split = date_parse_from_format('Y-m-d h:i:s', $creation_date);

       // var_dump($split); 
       //echo  $year_alone = date('Y',strtotime($creation_date))."<br>";
    //    list($date, $time)=explode(' ', $creation_date);
    //    echo "date:". $date;
    //    echo "<br>time:". $time;
       //echo  $date_alone = date('d',strtotime($creation_date))."<br>";

        // if ($diff > $year) {
        //     $current = false;
        // } else {
        //     $current = true;
        // }
         return $current;

        // echo "time: " . $st;
        // echo "<br>";
        // echo "now:" . $currentTime;
        // echo "<br>";
        // echo "diff: ". $diff;
        // echo "<br>";
        // echo "a year = ".$year;
        // echo "<br>";
        // if ($current) {
        //     echo "Current";
        // } else {
        //     echo "Not current";
        // }
        // echo "<br><br>";
    }
    

    function outputString() {
        echo "Title: " . $this->title." | ";
      //  echo "ID: " . $this->id." | ";
        echo "category: " . $this->category." | ";
    }

    function myJSON() {
        $myString = $this->id;
        return "{ id: ". $myString.", t: '".$this->title."', cr: '".$this->created."', w: '".$this->width."', h: '".$this->height."', cat: '".$this->category."', s: ".$this->sold.", arc: ".$this->archived." }";

       }

    function get_created_dateObject_as_formatted_string() {
        $date = $this->get_created_dateObject();
        $SQLString = date_format($date, 'Y-m-d H:i:s');
        return $SQLString;
    }

    function get() {
        $this->get_created_dateObject();
        $currentTime = time();

        $st = strtotime($this->created);
        $diff = $currentTime - $st;
        $year = 60*60*12*512;
        
        if ($diff > $year) {
            $current = false;
        } else {
            $current = true;
        }
        return $current;

        // echo "time: " . $st;
        // echo "<br>";
        // echo "now:" . $currentTime;
        // echo "<br>";
        // echo "diff: ". $diff;
        // echo "<br>";
        // echo "a year = ".$year;
        // echo "<br>";
        // if ($current) {
        //     echo "Current";
        // } else {
        //     echo "Not current";
        // }
        // echo "<br><br>";
    }

    function get_created_dateObject() {
        date_default_timezone_set('America/Los_Angeles');
        $format = 'Y-m-d H:i:s';
        // if (isset($this->created_dateObject)) {
        //     return $this->created_dateObject;
        // } else {
            if ($this->created) {
                $this->created_dateObject = new DateTime($this->created);
            } else {
            $this->created_dateObject = date_create('now');
            $this->created = $this->created_dateObject->format('Y-m-d H:i:s');
            }
            return $this->created_dateObject;
     //   }

    }

    function loadImages() {
        $db = $_SESSION['artwork_db'];
       // echo "LOading Images...<br>";
        if ($db) {
            if ($this->id !=0) {
            $queryString = "SELECT * FROM `images` WHERE artwork_id = ".$this->id.";";

            $data =[];
            $result = mysqli_query($db, $queryString);

            if ($result) {
                while ($row = mysqli_fetch_row($result)) {
                        array_push($data, $row);
                }
            } else { return null; }

            foreach($data as $index => $line) {
               // $filename = new artworks($line);
              // print_r($line);
              // echo "<br>";
               $image = new images($line);
                array_push($this->images, $image);
            }
         }
        }
    }

   
    function output() {
        echo "<p>Title: ".$this->title."</p>";
        echo "<p>Created: ".$this->created."</p>";
        echo "<p>Width: ".$this->width."</p>";
        echo "<p>Height: ".$this->height."</p>";
        echo "<p>Archived: ".$this->archived."</p>";
    }

    function displayThumbs() {
        if ($this->images && $this->images[0]) {
            
            foreach ($this->images as $key => $image) {
               
                // Note:  I am using the key here instead of the id of the image
                // which is just the index of the image array -- rather than
                // the ID of the image itself

                    echo "<img class='thumbnail' src='uploads/artwork/".$image->image_filename."' data-id='".$this->id."' data-img='".$key."'>";
                
            }
          
        }
    }

    function display() {
        if ($this->images && $this->images[0]) {
            echo "<div class='largeImageContainer '>";
      
            foreach ($this->images as $key => $image) {
                if ($key == 0) {
                    if ($image->orientation=='portrait') {
                      echo "<img class='largeImage current portrait'   src='uploads/artwork/".$image->image_filename."' data-img='".$key."'>";
                    } else {
                        echo "<img class='largeImage current landscape'   src='uploads/artwork/".$image->image_filename."' data-img='".$key."'>";
                    }
                } else {
                    if ($image->orientation=='portrait') {
                      echo "<img class='largeImage notcurrent portrait' src='uploads/artwork/".$image->image_filename."' data-img='".$key."'>";
                    } else {
                        echo "<img class='largeImage notcurrent landscape' src='uploads/artwork/".$image->image_filename."' data-img='".$key."'>";
     
                    }
                }
            }
           
            echo "</div>";
          
        }
    }
    function catalogOutput() {
        // only output the piece info if there is at least one image
        if ($this->images && $this->images[0]) {
        echo "<div class='workContainer'>";
        foreach ($this->images as $key => $image) {
            if ($key == 0) {
                echo "<div class='workImageContainer group'>";
                echo "<img class='workImage' src='uploads/artworks/".$image->image_filename."' data-id='".$this->id."'><br>";
                echo "</div>";
            }
        }
 
        echo "<p class='title'>".$this->title."</p>";
        echo "<p class='date'>";
        echo date("F jS, Y", strtotime($this->created));
        echo "</p>";;
        echo "</div>";
        
      }
    }
    function admin_tableOutput() {
        
        echo "<div class='cRow action' data-cat='".$this->category."' data-action='edit' data-id='".$this->id."' data-title='".$this->title."' 
        data-created='".$this->created."' 
        data-archived='".$this->archived."'
        >";
        echo "<table class='adminBlockContainer'>";
        echo "<tr>";
        echo "<td class='thumbnailTD'>";
        if (count($this->images)==0) {
            echo "<div class='thumbnailContainer'>";
            echo "<img class='thumbnail action' data-action='edit' data-id='".$this->id."' src='../uploads/missing.jpg'>";
            echo "</div>";
        }
        foreach ($this->images as $key => $imageObject) {
            //echo $filename[0];
            
            echo "<div class='thumbnailContainer'>";
            //print_r($imageObject);
            if ($imageObject->image_filename != '') {
            echo "<img class='thumbnail'  src='../uploads/artwork/".$imageObject->image_filename."'>";
            } 
        }
            echo "</div>";
            echo "</td>";
            //echo "</div>";
            echo "<td class='workinfo' width='50%'>";
            echo "<h1>".$this->title."</h1>";
            echo "<p class='date'>". $this->shortDate()."</p>";
            echo "<p class='size'>";
            echo $this->width." X ";
            echo $this->height."</p>";
            
            if ($this->sold) { echo "<span class='soldSpan'></span>"; } 
            // echo "<a href='removeimage.php?id=".$this->id."&image=".$imageObject->id."'>";
           // echo "<div class='killBox' data-id='".$imageObject->id."'>x</div>";



           if (!$this->archived) {
            echo "<div class='action remove actButton' data-action='remove' data-id='".$this->id."'></div>";
            //    echo "<div class='action actButton' data-action='edit' data-id='".$this->id."'>Edit</div>";
              
               echo "<div class='action actButton' data-action='archive' data-id='".$this->id."'>Archive</div>";
          
           // We don't need user confirmation to archive a piece - so we
           // send the link directly to the php file
                } else {
               // echo "<a href='unarchivethis.php?id=".$this->id."'>Un-Archive This piece</a><br>";
               echo "<div class='action actButton' data-action='unarchive' data-id='".$this->id."'>Put this back in</div>";
           }





            echo "</td>";
            //echo "<br clear='all'>";
        
 

   
    //    echo "<td class='cActions'>";
    //    if (!$this->archived) {
    //     echo "<div class='action remove actButton' data-action='remove' data-id='".$this->id."'></div>";
    //     //    echo "<div class='action actButton' data-action='edit' data-id='".$this->id."'>Edit</div>";
          
    //        echo "<div class='action actButton' data-action='archive' data-id='".$this->id."'>Archive</div>";
      
       // We don't need user confirmation to archive a piece - so we
       // send the link directly to the php file
            // } else {
           // echo "<a href='unarchivethis.php?id=".$this->id."'>Un-Archive This piece</a><br>";
    //        echo "<div class='action actButton' data-action='unarchive' data-id='".$this->id."'>Put this back in</div>";
    //    }
       echo "</td>";
       // here we need user confirmation, so we send the id to the javascript
       // method first
     
       echo "</tr></table></div>";
    }

    // take this artwork's values and create a safe mirrored version of them for SQL 
    function generateSQLSafeEntries() {
        $myRegex = '/\'/';
        // This makes it so that we can include an apostrophe in the title -- but nowhere else
       $this->SQL_title = preg_replace( $myRegex, "''", $this->title);
    //    $this->SQL_width = preg_replace( $myRegex, '', $this->width);
    //     $this->SQL_height = preg_replace( $myRegex, '', $this->height);
    //     $this->SQL_category = preg_replace( $myRegex, '', $this->category);
       //$this->SQL_title = $this->title;
        $this->SQL_width = $this->width;
        $this->SQL_height= $this->height;
        $this->SQL_category = $this->category;

    }
    function save() {
        $db = $_SESSION['artwork_db'];
        //$id = save_work($this, $db);
        if (!$this->sold) {
            $this->sold = 0;
        } else {
            $this->sold =1;
        }

        $createdString = $this->get_created_dateObject_as_formatted_string();
        $this->generateSQLSafeEntries();
        $sqlInsert = "INSERT INTO `artworks` ( `title`, `created`,`width`, `height`, `category`, `sold`, `archived` ) VALUES ( '".$this->SQL_title."', '".$createdString."', '".$this->SQL_width."', '".$this->SQL_height."', '".$this->SQL_category."', $this->sold, 0 );";

        $result = $db->query( $sqlInsert);
    
        if (!$result) {
            echo "error saving the artwork to the database.";
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
        update_work($this, $db);
        return true;
    }

    function humanReadableCreatedDate() {
        $middle = strtotime($this->created);   
        $new_date = date('F j, Y', $middle);
        return $new_date;
    }

    function shortDate() {
        $dateInQuestion = strtotime($this->created); 
        $output = date('M Y', $dateInQuestion); 
        return $output;
    }

    function simpleDate() {
        $middle = strtotime($this->created);   
        $new_date = date('F Y', $middle);
        return $new_date;
    }


    function grab_form_for_piece_data() {
        if (isset($_POST['category'])) {
            $this->category = $_POST['category'];
        } 

        if (isset($_POST['title'])) {$this->title = $_POST['title'];}

        if (isset($_POST['created'])) {
            // We need to convert the date form the human readable version to a db friendly version.
            $created = $_POST['created'];
            $middle = strtotime($created); 
            $newCreated =  date('Y-m-d H:i:s',$middle);
            $this->created = $newCreated;
        }
        if (isset($_POST['width'])) {
        $this->width = $_POST['width'];} 

        if (isset($_POST['height'])) {
        $this->height = $_POST['height']; }

        if (isset($_POST['category'])) {
          $this->category = $_POST['category'];
        } 
        $this->sold = false;
        if (isset($_POST['sold'])) {
            echo "<br> SOLD IS: ";
            echo $_POST['sold'];
            echo "<br>";
            if ($_POST['sold'] == 'sold') {
            $this->sold = true; }
        }
        
        return;
    }

}

?>
