<?php



function trytoFind($id, $pieces) {
	foreach($pieces as $index => $piece) {
		if ($piece->id == $id) {
			//found it.
			return true;
		}
	}
	return false;
}

function matchFilename($file, $imageObjects) {

	$split = explode('/', $file);
	$name = $split[3];

	foreach($imageObjects as $index => $object) {

		if ($name == $object->image_filename) {
			return true;
		}
	}
	return false;
}

function findDuplicates($artwork_id) {
	$diagdb = $_SESSION['artwork_db'];
	$imageObjects = load_images($diagdb, 'all');
	$found = false;
	foreach($imageObjects as $index => $object) {

		if ($object->artwork_id == $object->artwork_id) {
			if ($found) {
				//echo "Found a duplicate: ".$object->artwork_id."<br>";
			} else {
			$found = true; }
		}
	}
	return false;
}
function db_diagnostics() {
	$notices = [];

	echo "<div class='programmer_text'>";
		$diagdb = $_SESSION['artwork_db'];
		$pieces = load_art($diagdb, 'all', true); // include the archived images
		$imageObjects = load_images($diagdb, 'all');

		if (sizeof($pieces)>1) {
			echo "<p>There are ". sizeof($pieces)." pieces of artwork saved in the db.</p>";
		}
		if (sizeof($imageObjects)>1) {
			echo "<p>There are ". sizeof($imageObjects)." associated images saved in the db.</p>";
		}

		$folderPath = '../uploads/artwork/';
		$filearray = glob($folderPath . '*');
		$countFile = 0;
		if ($filearray != false)
		{
			$countFile = count($filearray);
		}
		echo "<p>There are ".$countFile." image files in the upload/artwork folder.</p>";
		echo "</div>"; //end of programmer text div

		$workcount = count($pieces);
		$imagecount = count($imageObjects);
		$filecount = $countFile;


		if ($workcount > $imagecount) {
			$missing_count = $workcount - $imagecount;
			array_push($notices, "There are ".$missing_count." pieces that are missing an image.");
		}
		if ($workcount != $imagecount || $imagecount !=$filecount) {

		
		if (count($imageObjects) > count($pieces) ) {
			$badImages = [];
			
			
			foreach($imageObjects as $index => $object) {
				// echo "About to look for duplicates of: ";
				// echo $object->artwork_id;
				// echo "<br>";
				//$dup = findDuplicates($object->artwork_id);
				$this_artwork_id = $object->artwork_id;

				$found = trytoFind($this_artwork_id, $pieces);
			//	echo $this_artwork_id.": ".$found."<br>";
				if (!$found) {
					echo "Image id: " + $object->id.", has no corresponding image object.<br>";
					array_push($badImages, $object->id);
				}


			}
			// echo "<p class='warning'>There are more image objects than artwork objects.";
			// echo "</p>";

		}

		if (count($imageObjects) < $countFile) {
			// find out which image(s) are ghosts
			echo "<div class='programmer_text'>";
			echo "<p class='warning' >There are more files than image objects:<br>";

			$offending_files = [];
			
			foreach($filearray as $index => $file) {
				if (!matchFilename($file, $imageObjects)) {
					// offending file
					echo $file." does not have a corresponding object in the db.<br>";
					array_push($offending_files,$file);
				}
			}
			$_SESSION['offending_file_array'] = $offending_files;
			echo "<a href='remove_extras.php' class='warningAction'>Delete these extra files.</a>";
			echo "</p>";
			echo "</div>";

		}
	}
	return $notices;
}




?>