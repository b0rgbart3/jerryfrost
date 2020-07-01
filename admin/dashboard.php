<?php
	session_start();	
	include_once '../config.php';
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
    require_once '../classes/artworks.php';
	include_once '../scripts/in_memory_functions.php';
	include_once "../classes/images.php";
	include_once "../classes/shows.php";
	include_once "../constants.php";
	include_once 'scripts/save.php';

	//phpinfo();


	function detectChange($post) {
		if (isset($post) && isset($post[0] ) ) 
			{
				$id = $post[0];
				$artwork = findArtwork($id);
				$changed = false;
				if ($artwork != null) {
					
					if ($artwork->title != $post[1]) {
						 $changed = true; }
					if ($artwork->created != $post[2]) {
							$changed = true; }
					if ($artwork->width != $post[3]) {
						$changed = true; }
					if ($artwork->height != $post[4]) {
						$changed = true; }	
					if ($artwork->sold != $post[5]) {
						$changed = true;
					} 
					if ($changed) {
						$artwork->title = $post[1];
						$artwork->created = $post[2];
						$artwork->width= $post[3];
						$artwork->height = $post[4];
						if ($post[5] == 'sold') {
						$artwork->sold = 1;} else {
							$artwork->sold=0;
						}
						$artwork->update();
						return true;
					}
				}
			}
			return false;
	}
	function separateData() {
		$inputs = 6;
		$datums = count($_POST);
		$postlist = [];
		$somethingChanged = false;

		//convert the $_POST array to a non-associative array

		$na_postArray = [];
		//print_r($_POST);
		
		$index = 0;
		foreach($_POST as $key => $postItem) {
			
			//echo "sold: ". $post['sold_'.$index];
		//	echo "<br>".$key.": ";
			//echo($postItem);
			
			array_push($na_postArray,$postItem);
		//	echo "<br>";
		}
		
		foreach($na_postArray as $element) {
		//	echo($element);
		//	echo "<br>";
		}

		$postDatumCount = count($na_postArray);
		$objectCount = count($na_postArray) / $inputs;
	//	echo "Post Datum Count: " . $postDatumCount."<br>";
	//	echo "Count: " . $objectCount."<br>";


		for($i =0; $i < $datums; $i++) {
			$id = $na_postArray[$i++];

		//	echo "<br>ID: ".$id."<br>";
			$title = $na_postArray[$i++];
		//	echo "title: ".$title."<br>";
			$created = $na_postArray[$i++];
			//echo "created: ".$created."<br>";
			$width = $na_postArray[$i++];
			
			$height = $na_postArray[$i++];
		//	$category = $na_postArray[$i++];
		//	echo "category: ".$category."<br>";
			$sold = $na_postArray[$i];

			$post = [$id,$title,$created,$width,$height,$sold];
			array_push($postlist,$post);
		}

		//echo count($postlist)."<br>";

		foreach($postlist as $post) {
			
		//	print_r($post);
		//	echo "<br><br>";
			$change = detectChange($post);
		
			if($change) {
				$somethingChanged = true;
			}
			// $change = false;
	
		}

		return $somethingChanged;
	}
	if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == false)
	{
		header("Location: admin.php");
	//print_r($_SESSION);
	//echo "...........";
	//echo "...........";
	}

	include_once 'head.php';
    include_once "db_diagnostics.php";

	$db = $_SESSION['artwork_db'];
	$_SESSION['newImage'] = null;
	$_SESSION['tmpFile'] = null;


	$url = $_SERVER['REQUEST_URI'];

	

	if ($_SERVER["REQUEST_METHOD"] == "POST") { 

			$changeFound= separateData();
			

		echo "<script>$( function() {";
			if ($changeFound) {
				echo "window.changeMade = true;";
			} else {
				echo "window.changeMade = false;";
			}
		echo " showList();});</script>";
	}








?>
<html>
<head>
<title>Admin Dashboard - for JerryFrost</title>
<script src='../js/config.js'></script>
</head>

<body>
<div class='adminBanner group'>
Jerry's Admin Dashboard
</div>
<a href='../index.php'>
<div class='backArrow'>Back to the website</div></a><br>


<div class='logout'><a href='logout.php'>Log out</a></div>
<div class='adminpage'>		
	
			
<div class='dash'><br>
<a href='add_piece.php'><div class='add'>Add a painting</div></a>
<a href='add_show.php'><div class='add'>Add a show</div></a>
<br clear='all'>
<br clear='all'>
<br clear='all'>
<?php
$works = null;
// include the archived images

$works = load_art($db, 'all', true); 
$images = load_images($db, 'all');
$shows = load_shows($db);
$_SESSION['works'] = $works;
$_SESSION['images'] = $images;
$_SESSION['shows'] = $shows;

$notices = db_diagnostics();

?>
<div class='tab tab_selected' data-tab='collection' id='collectionTab'>The Main Collection</div>
<div class='tab' data-tab='archive' id='archiveTab'>Hidden Archive</div>
<div class='tab' data-tab='list' id='listTab'>Detailed List</div>
<div class='tab righttab' data-tab='shows' id='showsTab'>Shows</div>
<?php 


if (sizeof($works) < 1) {
	echo "<a href='scripts/create_artworks_table.php'>Create Artworks Table</a>";

} else {

	echo "<br clear='all'><div class='categoryButtons' id='categoryButtons'>
	<ul>
	<li id='socialButton'>Social</li>
	<li id='abstractButton'>Abstract</li>
	<li id='figurativeButton'>Figurative</li>
	<li id='landscapeButton'>Landscape</li>
	</div>";

	// $cats = $_SESSION['categories'];
	
	// foreach($cats as $catIndex => $cat) {
				
	// 			$work = segment_work($cat);
	echo "<div class='section adminContent' id='collection'>";
	echo "<ul class='filter'><li id='newest_filter'>Sort By Newest</li>
	<li id='created_filter'>Sort By Oldest</li>
	<li id='title_filter'>Sort By Title</li></ul>";
	foreach($works as $work) {

				// foreach($work as $workIndex => $awork) {
				// 	if (!$awork->archived) {
					$work->admin_tableOutput(); 
					
//				}
				
	//		}
		
		
		//	echo "</div>";
	}
	echo "</div>";
	echo_table_header('archive');
	echo "<br>";
	$archive_count = 0;
	foreach($works as $workIndex => $work) {
		if ($work->archived) {
			$archive_count++;
	//$work->admin_tableOutput(); 
		} 


	}
	if ($archive_count == 0 ) {
		echo "<p>&nbsp; The archive is currently empty.</p>";
	}
	echo "</div>";

	echo_table_header('showsPanel');
	foreach($shows as $showIndex => $show) {
		if ($show) {
	      $show->admin_tableOutput(); }
		}
	}
	echo "</div>";
	echo_table_header('list');
	
	echo "<div class='notices'>";
	echo "<p>There are ".count($works)." pieces in the database.</p>";
	if(count($notices)>0) {
		
		foreach($notices as $notice) {
			echo "<p>".$notice."</p>";
		}
	}
	echo "</div>";


	
	echo "<br clear='all'>";
	echo "<div class='updateNotice' id='updateNotice'>The database has been updated.</div>";
	echo "<div class='search'>";
	echo "Search:";
	echo "<input type='text' name='search' id='search' autocomplete='off' onChange='search(event);'>";
	echo "</div>";
	echo "<form action='". htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post' class='group' >";
	echo "<input type='submit' value='submit changes' class='action noticeMe'>";
	outputList($works);
	echo "<input type='submit' value='submit changes' class='action noticeMe'>";
	echo "</form>";
	echo "</div>";


	

// if (sizeof($works) < 1) {
// echo "<br><br><br><a href='scripts/create_images_table.php'>Create Images Table</a>";
// }
function echo_table_header($header_id) {
	echo "<div class='collectionTable adminContent' id='".$header_id."' >";
//	echo "<tr><td colspan='3' class='headerbar'></td></tr>";
}

?>
<br><br><br><br>
<div class='programmer_text'>
<a href='add_multiple_pieces.php'><div class='add'>Upload Multiple images at once</div></a>
<a href='auto_generate.php'>Auto Generate</a>
</div>
</div>


</div>
<?php
// if (sizeof($shows) < 1) {
// 	echo "<a href='scripts/create_shows_table.php'>Create Shows Table</a>";

// }

function outputList($works) {
	echo "<table class='listtable'>";
	echo "<tr class='listheader'><td></td><td class='sorter' data-sort='title' id='sort_title' width='12%'>title</td>
	<td class='sorter' data-sort='created' id='sort_created' width='10%'>creation date</td>
	<td style='text-align:center'>width</td><td></td><td>height</td>
	<td  class='sorter' data-sort='category' id='sort_category'>category</td><td>sold</td>
	<td style='text-align:right'>remove</td></tr>";
	foreach($works as $workIndex => $awork) {
		if (!$awork->archived) {
		
			$id = $awork->id;
		// here we are passing data to JS
		echo "<tr class='listRow' data-id='".$awork->id."' data-title='".$awork->title."' data-created='".$awork->created."' data-category='".$awork->category."'>";
		echo "<td>";
		echo "<a href='edit.php?id=".$awork->id."'>";
		echo "<div class='tinythumbBox'>";
		if (isset($awork->images) && isset($awork->images[0]) && (isset($awork->images[0]->image_filename) )
		&& ($awork->images[0]->image_filename!='')  ) 
		{
			echo "<img class='tinythumb' src='../uploads/artwork/".$awork->images[0]->image_filename."'>";
		} else {
			
			echo "<div class='action tinyaction'>Edit</div>";
			
		}
		echo "</a>";
		
		echo "</div>";
		echo "</td>";
		echo "<td>";
		echo "<input type='hidden' name='id_".$id."' id='".$id."' value='".$id."'>";
		echo '<input type="text" name="title_'.$id.'" id="title_'.$id.'" autocomplete="off" value="';
		echo $awork->title;
		echo '">';
		echo "</td>";
		echo "<td>";
		echo "<input type='text' name='created_".$id."' id='created_".$id."' autocomplete='off' value='".$awork->humanReadableCreatedDate()."'>";
		echo "</td>";
		echo "<td>";
		echo "<input type='text' name='width_".$id."' id='width_".$id."' autocomplete='off' value='".$awork->width."' class='small'>";
		echo "</td>";
		echo "<td style='color:#999999'> X </td>";
		echo "<td>";
		echo "<input type='text' name='height_".$id."'' id='height_".$id."' autocomplete='off'  class='small' value='".$awork->height."'>";
		echo "</td>";
		echo "<td>";
		echo $awork->category;
		// echo "<select name='category_".$id."' id='category_".$id."'>";
		// echo "<option value='social' ";
		// if (($awork->category == null) || ($awork->category=='') || ($awork->category == "social") ) { 
	
		// 	echo "selected"; 
			
		// }
		// echo ">Social</option>";
		// echo "<option value='abstract' ";
		// if ($awork->category == "abstract") { echo "selected"; } 
		// echo ">Abstract</option>";
		// echo "<option value='figurative' ";
		// if ($awork->category == "figurative") { echo "selected"; }
		// echo ">Figurative</option>";
		// echo "<option value='landscape' ";
		// if ($awork->category == "landscape") { echo "selected"; } 
		// echo " >Landscape</option>";
		// echo "</select>";
	
		echo "</td>";
		echo "<td>";
		echo "<input type='checkbox' id='sold_".$id."' name='sold_".$id."' value='notsold' checked class='hideme'>";
		echo "<input type='checkbox' id='sold_".$id."' name='sold_".$id."' value='sold' ";
		if ($awork->sold) {
			echo " checked ";
		}
		echo ">";
		//echo $awork->sold;
		echo "</td>";
		echo "<td>";
		echo "<div class='action tinyremove' data-action='remove' data-id='".$awork->id."'></div>";
		echo "</td>";
		
		echo "</tr>";
		
		
	}}
	echo "</table>";
}
?>
</body>
</html>


