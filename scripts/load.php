<?php
include_once 'pathinfo.php';
include_once 'database.php';
include_once $path."scripts/load.php"; 
include_once $path.'classes/artworks.php';
include_once $path.'classes/shows.php';

function load_images($db) {
    $images = [];

    $data = fetch_images($db);

    if ($data != null) {
    foreach($data as $index => $line) {
       $object = new images($line);
       //echo "In load.php, line 29.<br>";

       array_push($images, $object);
   } }


    $_SESSION['images'] = $images;

    return $images;

}

function load_shows($db) {
    $shows = [];

    $data = fetch_shows($db);

    if ($data != null) {
    foreach($data as $index => $line) {
       $object = new shows($line);

       array_push($shows, $object);
   } }


    $_SESSION['shows'] = $shows;

    return $shows;

}

/* 
 *
 * Fetch shows data from the db
 * 
 */

function fetch_shows($db) {

    $data = [];
    $objects = [];

    if ($db) {

        $queryString = "SELECT * FROM `shows`";

        $result = mysqli_query($db, $queryString);

        
        if (!$result) {
            // die("<p>Error in fetching data from ".$tableName.": " . $db->error . "</p>");
            return null;
        }

        if ($result) {
            while ($row = mysqli_fetch_row($result)) {
                    array_push($data, $row);
            }
        }

        return $data;

    }

}

// filter out the works that don't have images uploaded
function load_art_with_images($db, $category, $includeArchive) {
    $works = load_art($db, $category, $includeArchive);
    $safeworks = [];
    foreach($works as $workIndex => $work) {
            
        $image = findImage($work->id);
        if ($image && $image->image_filename !='') {
            array_push($safeworks, $work);
        }
    }
        return $safeworks;

}

function load_full_works_by_category() {
    $works = [];
    $categories = ['current','social','abstract','figure','landscape'];
    
    $works['current'] = [];
    $works['social'] = [];
    $works['abstract'] = [];
    $works['figure'] = [];
    $works['landscape'] = [];

    $data = simple_fetch_artwork();
    if ($data != null) {
       
        // separate out the artworks into arrays for each category
        foreach($data as $index => $artwork) {
            if ($artwork->category == null) {
                echo "Null<br>";
            }
            array_push( $works[ $artwork->category ], $artwork);
        }

      
    }
    $_SESSION['works_by_category'] = $works;
}

function load_full_works() {
    $works = [];
    $data = simple_fetch_artwork();
    if ($data != null) {

        $_SESSION['works'] = $data;
        $_SESSION['work_count'] = count($data);
        // foreach($data as $work) {
        //     $work->outputString();
        // }
    }

    
}

/* 
 *
 * Fetch artwork data from the db, and create new artwork objects
 * out of that data.
 * Note: this function depends on the fact that the artwork class
 * constructor takes in an array and assigns the values accordingly.
 * 
 */

function simple_fetch_artwork() {

    $data = [];
    $objects = [];

    if ( isset($_SESSION['artwork_db'])) {
        $queryString = "SELECT * FROM `artworks` ORDER BY `created` DESC";   
        $result = mysqli_query( $_SESSION['artwork_db'], $queryString);
        
        if (!$result) {
            // die("<p>Error in fetching data from ".$tableName.": " . $db->error . "</p>");
            return null;
        }

        if ($result) {
            while ($row = mysqli_fetch_row($result)) {

                    $artwork = new artworks($row);
                    array_push($data, $artwork);
            }
        }
       // print_r($data);
        return $data;

    }

}

function load_art($db, $category, $includeArchive) {
 
     // Heck - Let's go ahead and just load in all the data
     // and store it in the Session vars so that it's easily accessible.
     // This might require a security improvement - such as nonces and /or hashes - as a future upgrade
 
     // Grab the Data, man!
     $works = [];
 
     if (isset($_SESSION['sort']) && ( $_SESSION['sort']!='')) {
       
        $sort = $_SESSION['sort'];
       // echo "sort has been set to: " . $sort;
    } else {
        //echo "not set:";
        $sort = 'created';
        $order = 'DESC';
    }

     if (isset($_SESSION['order']) && ( $_SESSION['order']!='')) {
         //echo "set:";
         $order = $_SESSION['order'];
     } else {
         //echo "not set:";
         $order = '';
     }

     if ($order != 'ASC' && $order!= 'DESC') {
         $order = 'ASC';
     }
     if ($sort != 'title' && $sort != 'created' && $sort!= 'category') {
         $sort = 'title';
     }
    // echo "SORT BY:" .$sort."<br>";
    //echo "ORDER: ".$order."<br>";
 
     $data = fetch_artwork($db, $category, $includeArchive, $sort, $order);

     if ($data != null) {
     foreach($data as $index => $line) {
        $object = new artworks($line);
        //echo "In load.php, line 29.<br>";

        array_push($works, $object);
    } }

 
    /* close connection */
     //$db->close();
     //unset($db);

    // $_SESSION['works'] = $works;

    //   echo "SESSION WORKS:<br>";
    //  foreach($_SESSION['works'] as $work) {
    //      echo $work->title."<br>";
    //  }
     return $works;
}

/* 
 *
 * Fetch artwork data from the db
 * 
 */

function fetch_artwork($db, $category, $includeArchive, $sort, $order) {

    $data = [];
    $objects = [];

    if ($db) {

        switch ($category) {
            case 'current':  
              $search_category = 'all';
              $queryString = "SELECT * FROM `artworks` WHERE `created` >= '2019-01-01'";
              if (!$includeArchive) {
                  $queryString .= " AND `archived` < 1";
                  $queryString .= " ORDER BY `".$sort."` ".$order;
              }
              break;
            case 'all': 
          //  echo "all loading";
              $search_category = 'all';
              $queryString = "SELECT * FROM `artworks`";
              if (!$includeArchive) {
                $queryString .= " WHERE `archived` < 1";
                
               }
               $queryString .= " ORDER BY `".$sort."` ".$order;
              // echo "query: " . $queryString;
              break;
            default:
              $search_category = $category; 
              $queryString = "SELECT * FROM `artworks` WHERE `category`='".$search_category."'";
              if (!$includeArchive) {
                $queryString .= " AND `archived` < 1";
              }
              $queryString .= " ORDER BY `".$sort."` ".$order;
              break;
        }

    //  echo "Query: " . $queryString."<br>";
        $result = mysqli_query($db, $queryString);

        
        if (!$result) {
            // die("<p>Error in fetching data from ".$tableName.": " . $db->error . "</p>");
            return null;
        }

        if ($result) {
            while ($row = mysqli_fetch_row($result)) {
                    array_push($data, $row);
            }
        }

  

        /* close connection */
        // $db->close();
        // unset($db);
        return $data;

    }

}


/* 
 *
 * Fetch artwork data from the db
 * 
 */

function fetch_images($db) {

    $data = [];
    $objects = [];

    if ($db) {

        $queryString = "SELECT * FROM `images`";

        $result = mysqli_query($db, $queryString);

        
        if (!$result) {
            // die("<p>Error in fetching data from ".$tableName.": " . $db->error . "</p>");
            return null;
        }

        if ($result) {
            while ($row = mysqli_fetch_row($result)) {
                    array_push($data, $row);
            }
        }

        return $data;

    }

}

?>
