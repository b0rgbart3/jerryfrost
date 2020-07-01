<?php 

// function save_work($artwork, $db) {

//     $sqlInsert = "INSERT INTO `artworks` ( `title`, `created`,`width`, `height`, `category`, `sold`, `archived` ) VALUES ( '".$artwork->title."', '".$artwork->created."', '".$artwork->width."', '".$artwork->height."', '".$artwork->category."', $artwork->sold, 0 );";

//     $result = $db->query( $sqlInsert);

//     if (!$result) {
//         echo "eror saving to the database.";
//         $newid = 0;
//     } else {
//         $newid = $db->insert_id;

//     }
    
//     return $newid;  // this should return the id of the saved artwork;
// }

function update_work($artwork, $db) {

    $artwork->generateSQLSafeEntries();
    $sqlInsert = "UPDATE `artworks` SET `title`='".$artwork->SQL_title."', `created`='".$artwork->get_created_dateObject_as_formatted_string()."', `width`='".$artwork->width."', `height`='".$artwork->height."', `category`='".$artwork->category."', `sold`=".$artwork->sold.", `archived`=".$artwork->archived." WHERE `id`='".$artwork->id."';";

    $result = mysqli_query($db, $sqlInsert);

  //  echo $sqlInsert;
    
    if (!$result) {
        echo "error updating the artwork in the database.";
        echo $sqlInsert;
    } 
}

function removeimage($imageID, $db) {

    $result = mysqli_query($db, "DELETE FROM `images` WHERE `id`=".$imageID );

    if (!$result) {
        die("<p>Error in removing image: " . $db->error . "</p>");
    } else {
        return true;
    }


}


