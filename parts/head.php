<?php 
?>
<head>
<link rel="icon" href="jerry-favicon-32.png" sizes="32x32">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta property="og:title" content="Jerry Frost Artist">
<meta property="og:type" content="website">
<meta property="og:description" content="San Francisco Painter">
<meta property="og:image" content="http://jerryfrost.com/interface/jerry_og2.jpg">
<meta property="og:url" content="http://jerryfrost.com/">
<meta property="fb:app_id" name="fb_app_id" content="429912884431270"/>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,500,700" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Merriweather" rel="stylesheet">


  <?php 
  if ($isLocal) {
    echo "<script src='".$resource_path."js/nav.js'></script>";
    echo "<link rel='Stylesheet' href='".$resource_path."style/style_sheet.css'>";
    echo "<link rel='Stylesheet' href='".$resource_path."style/art.css'>";
    echo "<link rel='Stylesheet' href='".$resource_path."style/custom_select.css'>";
    echo "<link rel='Stylesheet' href='".$resource_path."style/nav.css'>";

  } else {
   // echo "NOT LOCAL";
  ?>
   <script src='/js/nav.js'></script>
    <link rel="Stylesheet" href="/style/style_sheet.css">   
    <link rel="Stylesheet" href="/style/art.css">   
    <link rel="Stylesheet" href="/style/custom_select.css">   
    <link rel="Stylesheet" href="/style/nav.css">  
  <?php } ?>

    <title>Jerry Frost - Artist</title>

</head>