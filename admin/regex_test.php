<?php


$myRegex = '/\'/';


$myTestString = "Testing this string's ability 2 - fuck me . _up!";

$clean = preg_replace( $myRegex, "''", $myTestString);

echo "My Original String: ".$myTestString."<br>";
echo "Clean Version: ".$clean."<br>";

echo "This is: ' ".$clean." ' mystring";

$sqlInsert = "INSERT INTO `artworks` ( `title`, `created`,`width`, `height`, `category`, `sold`, `archived` ) VALUES ( '".$clean."', 'next thing');";
//$sqlInsert .= $clean."',";

echo "<br>My SQL:<br>";
echo $sqlInsert;

?>