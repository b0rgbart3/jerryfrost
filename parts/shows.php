<?php
?>
<a name='upcoming'></a>
<div class='upcoming'>
<div class='container'>
<div class='content'>
<h1>Upcoming Shows</h1>

<?php 

if (!isset($shows) || sizeof($shows) < 1) {
  echo "<p>Please check back soon to find out when the next show is.</p>";
} else {
  echo "<p>Here's your chance to come see the work in person, and meet the artist. Come to one of these upcoming shows!</p>";
  foreach($shows as $show) {
      $show->displayValues();
      echo "<br clear='all'>";
  }
}
?>

</div>
</div>
</div>