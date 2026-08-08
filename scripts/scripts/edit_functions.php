<?php
function save_updated_info($id, $title, $width, $height, $month, $day, $year, $categories, $sold) {

//   echo "SOLD: ".$sold."<BR><BR>";

//   echo "SOLD: ".$sold."<BR><BR>";

    $found = false;

    $file_path = 'uploads/generated_list.json';


    // Check if the file exists
    $completeJsonString = '';
    if (file_exists($file_path)) {
        // Read the file contents

        // echo "<br>reading the file, and sold=".$sold."<br>";

        $file_lines = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $imageNumber = 0;
        $lineNumber = 0;
        $json_lines = [];
        array_push($json_lines, "{");
        array_push($json_lines, "  \"paintings\": [");

        $last_line = count($file_lines) - 4;


        // Read the file line by line
        foreach($file_lines as $line) {
            // $line = fgets($file);

            // Accumulate the lines
            $completeJsonString .= $line;
        }

       // fclose($file_path);

        $json_data = json_decode($completeJsonString, true);

        // Check for decoding errors
        if ($json_data === null && json_last_error() !== JSON_ERROR_NONE) {
            // echo 'Error decoding JSON: ' . json_last_error_msg();
        } else {
            // Your decoded data is now in the $data variable

        }

        $paintingNumber = 0;
        $paintingCount = count($json_data['paintings']);
        foreach($json_data['paintings'] as $artwork) {


            if ($artwork['categories']) {
            $combinedString = implode(", ", $artwork['categories']);
            } else {
                $combinedString = "";
            }
            // echo "categories: ".$combinedString;
            // echo "<br>";
            $paintingNumber++;


        if ($artwork['id'] === $id) {
            $json_line = "    { \"id\":  \"" . $id. "\", \"title\": \"".$title."\", ";
                $json_line = $json_line . "\"width\": \"".$width."\", ";
                $json_line = $json_line . "\"height\": \"".$height."\", ";
                $json_line = $json_line . "\"month\": \"".$month."\", ";
                $json_line = $json_line . "\"day\": \"".$day."\", ";
              
                $year = $year;
    
                if ($year) {
                    $json_line = $json_line . "\"year\": \"".$year."\" ";
                } 
                else {
                    $json_line = $json_line . "\"year\": \"2023\"";
                }
               
                $json_line = $json_line . ", \"categories\": [";
                $categoryCount = sizeof($categories);
                $catNumber = 0;
                foreach($categories as $category) {
                    $json_line = $json_line . "\"".$category."\"";
                    if ($catNumber < $categoryCount-1) {
                        $json_line = $json_line.",";
                    }
                    $catNumber++;
                }
                // echo "<BR>SOLD is currently: ".$sold;
                if ($sold == "true") {
                    // echo "<br> solid is TRUE, saving true.<br>";
                  $json_line = $json_line ."], \"sold\": true";
                } else {
                    // echo "<br> solid is NOT TRUE, saving false.<br>";
                    $json_line = $json_line ."], \"sold\": false";
                }
                $json_line = $json_line . "}";
        }
        else {
            $json_line = "    { \"id\":  \"" . $artwork['id']. "\", \"title\": \"".$artwork['title']."\", ";
            $json_line = $json_line . "\"width\": \"".$artwork['width']."\", ";
            $json_line = $json_line . "\"height\": \"".$artwork['height']."\", ";
            $json_line = $json_line . "\"month\": \"".$artwork['month']."\", ";
            $json_line = $json_line . "\"day\": \"".$artwork['day']."\", ";
           // $year = $artwork['year'];

            
                $json_line = $json_line . "\"year\": \"".$artwork['year']."\" ";
                $combinedString = implode(", ", $artwork['categories']);
                $json_line = $json_line . ", \"categories\": [";
                $categoryCount = sizeof($artwork['categories']);
                $catNumber = 0;
                foreach($artwork['categories'] as $category) {
                    $json_line = $json_line . "\"".$category."\"";
                    if ($catNumber < $categoryCount-1) {
                        $json_line = $json_line.",";
                    }
                    $catNumber++;
                }
                if ($artwork['sold']) {
                    $soldThis = true;
                } else {
                    $soldThis = false;
                }
                if ($soldThis) {
                    $json_line = $json_line ."], \"sold\": true";
                  } else {
                      $json_line = $json_line ."], \"sold\": false";
                  }
                $json_line = $json_line . "}";
        }


            if ($paintingNumber !== $paintingCount) {
                $json_line =  $json_line . ",";
            } 

        //    // $json_line = "another";
          array_push($json_lines, $json_line);
        }


    }


    array_push($json_lines, "  ]");
    array_push($json_lines, "}");
    $json_file_path = 'uploads/generated_list.json';
    $data_to_save = implode(PHP_EOL, $json_lines);
    file_put_contents($json_file_path, $data_to_save);
    
}

function remove_this_painting($id) {

      $found = false;
  
      $file_path = 'uploads/generated_list.json';
  
 

      // Check if the file exists
      $completeJsonString = '';
      if (file_exists($file_path)) {
          // Read the file contents
  
          $file_lines = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  
          $imageNumber = 0;
          $lineNumber = 0;
          $json_lines = [];
          array_push($json_lines, "{");
          array_push($json_lines, "  \"paintings\": [");
  
          $last_line = count($file_lines) - 4;
  
  
          // Read the file line by line
          foreach($file_lines as $line) {
              // $line = fgets($file);
  
              // Accumulate the lines
              $completeJsonString .= $line;
          }
  
         // fclose($file_path);
  
          $json_data = json_decode($completeJsonString, true);
  
          // Check for decoding errors
          if ($json_data === null && json_last_error() !== JSON_ERROR_NONE) {
            //   echo 'Error decoding JSON: ' . json_last_error_msg();
          } else {
              // Your decoded data is now in the $data variable
           //   print_r($json_data);
          }
  
          $paintingNumber = 0;
          $paintingCount = count($json_data['paintings']);
          foreach($json_data['paintings'] as $artwork) {
            
  
  
          if ($artwork['id'] === $id) {
            // echo "<br> Found artowrk id: ". $id;
          }
          else {
              $json_line = "    { \"id\":  \"" . $artwork['id']. "\", \"title\": \"".$artwork['title']."\", ";
              $json_line = $json_line . "\"width\": \"".$artwork['width']."\", ";
              $json_line = $json_line . "\"height\": \"".$artwork['height']."\", ";
              $json_line = $json_line . "\"month\": \"".$artwork['month']."\", ";
              $json_line = $json_line . "\"day\": \"".$artwork['day']."\", ";
             // $year = $artwork['year'];
  
              
                  $json_line = $json_line . "\"year\": \"".$artwork['year']."\", ";
      
                  $json_line = $json_line . "\"categories\": [";

                  $categoryCount = sizeof($artwork['categories']);
                  $catNumber = 0;
                  foreach($artwork['categories'] as $category) {
                      $json_line = $json_line . "\"".$category."\"";
                      if ($catNumber < $categoryCount-1) {
                          $json_line = $json_line.",";
                      }
                      $catNumber++;
                  }
                  $json_line = $json_line . "], ";

                  $json_line = $json_line . "\"sold\": \"".$artwork['sold']."\" ";
          
              $json_line = $json_line . "}";

        //    // $json_line = "another";
        // echo "<br>Painting: ". $paintingCount. " <br>";
        // echo $json_line . "<br>";

        $paintingNumber++;
        if ($paintingNumber < $paintingCount-1) {
            $lastChar = substr($json_line, -1);
            if ($lastChar !== ',') {

          $json_line =  $json_line . ",";
            }
      }  

      array_push($json_lines, $json_line);

          }
         

  

          }

     //     return 'Success';
  
  
      }
  
  
      array_push($json_lines, "  ]");
      array_push($json_lines, "}");
      $json_file_path = 'uploads/generated_list.json';
      $data_to_save = implode(PHP_EOL, $json_lines);
      file_put_contents($json_file_path, $data_to_save);


        $fileToDelete = 'uploads/'.$id.'.jpg'; 
        echo "file to delete: ". $fileToDelete;

        $message = '';
        if (file_exists($fileToDelete)) {
            if (unlink($fileToDelete)) {
                $message = 'File deleted successfully.';
            } else {
                $message = 'Error deleting file.';
            }
        } else {
            $message = 'File does not exist.';
        }

        return "Success";
      
  }