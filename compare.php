<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$filename = 'uploads/artwork/list.txt';


function compareJPEG($filename1, $filename2) {
    $path = 'uploads/artwork/';
   // echo "about to open.";
    $file1 = fopen($path.$filename1, 'rb');
    //echo "<br> file1 done.";
    $file2 = fopen($path.$filename2, 'rb');

    $areEqual = true;
    // echo "<br>iixx";
    while (!feof($file1) && !feof($file2)) {
     
        // Read 1KB (1024 bytes) from each file
        $data1 = fread($file1, 1024);
        $data2 = fread($file2, 1024);

        // Compare the data byte by byte
        if ($data1 !== $data2) {
            $areEqual = false;
            break;
        }
    }

    fclose($file1);
    fclose($file2);


    return $areEqual;
}

if (file_exists($filename)) {
    $file_lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

$lines = count($file_lines);

for ($i = 0; $i < $lines; $i++) {

    $filename1 = $file_lines[$i];

    for ($j = 1; $j < $lines; $j++) {
        $filename2 = $file_lines[$j];


        if ($filename1 !== $filename2) {
            //echo "<br>File1: ".$filename1.", file2: ".$filename2;

            //echo "<br>==<br>";
            $same = compareJPEG($filename1, $filename2);
            if ($same) {
            echo "<br>Same:".$filename1.", and: ".$filename2;
            }
        } 
       

        // Compare the binary data to see if the images are the same
        // if (compareJPEG($filename1, $filename2)) {
        //     echo "The images ".$i." and ".$j." are the same.";
        // } else {
        //     echo "The images ".$i." and ".$j." are different.";
        // }
    }
}

?>