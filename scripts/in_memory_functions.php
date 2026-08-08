<?php

function unescapeSingleQuotes($input_string) {


    // This makes it so that we can include an apostrophe in the title -- but nowhere else
    $output_string = $input_string;
    return $output_string;
}

function escapeSingleQuotes($input_string) {

   
    $myRegex = '/\'/';
    // This makes it so that we can include an apostrophe in the title -- but nowhere else
   // $output_string = preg_replace( $myRegex, "\'", $input_string);

   $output_string = json_encode($input_string);
    return $output_string;
}

// This finds an image with a corresponding artwork id
function findImage($id) {
    if (isset($_SESSION['images'] ) ) {
    $images = $_SESSION['images']; }
    else {
        if ($_SESSION['artwork_db']) { 
        $images = load_images($_SESSION['artwork_db']);
        $_SESSION['images'] = $images;
      }
    }

    foreach($images as $imageIndex => $image) {
        if ($image->artwork_id == $id) {
            $foundImage = $image;

            return $foundImage;
        }
    }
}
function findArtwork_with_title($title) {

    $works = $_SESSION['works'];
    // This should take spaces out of the title names so that we can compare them
    // with filenames that don't have spaces in them.
    
    $myRegex = '/\ /';

    foreach($works as $workIndex => $work) {
        $lowerTitle = strtolower($work->title);
        $lowerTitle = preg_replace( $myRegex, "", $lowerTitle);

        $lowerCheck = strtolower($title);
     //   echo $lowerCheck."<br>";
      //  echo $lowerTitle."<br>";

        if ( $lowerTitle == strtolower($title)) {
            // found it.
         //   echo "found it.<br>";
            $foundArtwork = $work;
        

            return $foundArtwork;
        }
    }

}

function findArtwork($id) {

    $works = $_SESSION['works'];

    foreach($works as $workIndex => $work) {
        if ($work->id == $id) {
            // found it.
            $foundArtwork = $work;
        

            return $foundArtwork;
        }
    }

}
function findShow($id) {

    $shows = $_SESSION['shows'];

    foreach($shows as $showIndex => $show) {
        if ($show->id == $id) {
            // found it.
            $foundShow = $show;
        

            return $foundShow;
        }
    }

}

function splitIntoCategories() {

   
    $categories = ['current','social','abstract','figurative','landscape','all'];
    $collections = [];
    $works = $_SESSION['works'];
   // printf($_SESSION['works']);

    //instantiate empty arrays
    foreach($categories as $category) {
        $collections[$category] = [];
    }

    foreach($works as $work) {
     
        //echo "work" .$work->created."<br>";
       // echo $work->title."<br>";

        if ($work->isCurrent() ) {
            array_push( $collections['current'], $work);
        }
        array_push($collections[$work->category],$work);

        //echo "category: ". $work->category. "<br>";
        array_push($collections['all'], $work);
    }
    return $collections;
}

function get_most_current_id() {
    $works = $_SESSION['works'];
   
    $collections = splitIntoCategories();
   // var_dump( array_keys($collections) );
    ///echo "<br>Collections[current]<br>";

    //var_dump( $collections['current']);
    //echo "# of current pieces: " . count($collections['current']) ."<br>";
    return $collections['current'][0]->id;
}
?>
