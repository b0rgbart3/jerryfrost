<?php
$directory = 'uploads/artwork'; // Replace with the actual path to your directory

// Check if the directory exists
if (is_dir($directory)) {
    // Get the list of files in the directory
    $files = scandir($directory);

    // Remove "." and ".." entries from the list
    $files = array_diff($files, array('..', '.'));


    // Display the list of files
    echo "List of files in $directory:\n";

     // Initialize an array to store filenames without extension
     $ids = array();

    foreach ($files as $file) {
      //  echo $file . "\n";
        if (pathinfo($file, PATHINFO_EXTENSION) == 'jpg') {
            
            $filenameWithoutExtension = pathinfo($file, PATHINFO_FILENAME);
              $ids[] = $filenameWithoutExtension;

        }

    }
    $idCount = sizeof($ids);
    echo "<br>Number of images total: ". $idCount;
} else {
    echo "Directory not found: $directory\n";
}



if ($ids && sizeof($ids) > 0) {

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
            echo 'Error decoding JSON: ' . json_last_error_msg();
        } else {
            // Your decoded data is now in the $data variable
         //   print_r($json_data);
        }

       
        $paintingCount = count($json_data['paintings']);

        $artworks_in_gallery = sizeof($json_data['paintings']);

        echo "<br>Number of images in our database: ". $artworks_in_gallery;

        $number_of_extra = $idCount - $artworks_in_gallery;

        echo "<br>That means there are ". $number_of_extra. " extra jpegs.<br>";

        $paintingNumber = 0;
        foreach($json_data['paintings'] as $artwork) {
            $paintingNumber++;

            foreach ($ids as $id) {
    
                echo "<br>ID: ". $id. ", ".$artwork['id'];
                if ($id === $artwork['id']) {
                // find ids that exist in our data, and then delete them from the list of orphans
                $key = array_search($id, $ids);
                echo "<br>This image exists in our database.";
                echo "<br>Key: ". $key;
                if ($key !== false) {
                    unset($ids[$key]);

                  }
                echo "<br>New size of id list: ". sizeof($ids);
                }
          }

        }
        echo "<br>These are the images that are not in the list:<br>";
        echo "<br>Size of remaininglist: ". sizeof($ids);
        foreach($ids as $id) {
            echo "<br>".$id;

            $fileToDelete = "uploads/artwork/".$id.".jpg";
            if (file_exists($fileToDelete)) {
                if (unlink($fileToDelete)) {
                    $message = 'File deleted successfully.';
                } else {
                    $message = 'Error deleting file.';
                }
            } else {
                $message = 'File does not exist.';
            }

            echo $message;
        }


    }


}
?>