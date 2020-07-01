<?php
session_start();

function save_this_file($dataname,$this_data_array)
{ 
 // print "saving.<br>";

  $filename = $_SESSION['path'].$dataname.".txt";
  //print "filename = " . $filename . "<br>";

  $handle = @fopen($filename, "w");
      if ($handle) {

        //print "got a handle.<br>";
      foreach ($this_data_array as $dataitem) {
       // print $dataitem . " == dataitem<br>";
        //$dataitem = $dataitem . "\n";
        fwrite($handle,$dataitem .  "///" . PHP_EOL);
        }
      fclose($handle);
      }

}


function verify_this_data($datatype, $newData, $dataNumber)
{
  $_SESSION[$datatype][$dataNumber] = $newData;
  save_this_file($datatype,$_SESSION[$datatype]);
     // if ($newData != $_SESSION[$datatype][$dataNumber])
     // {
     //   $_SESSION[$datatype][$dataNumber] = $newData;

     //   save_this_file($datatype,$_SESSION[$datatype]);
     // }

}


function save_new_data($slideNumber, $newTitle, $newWidth, $newHeight, $newDescription) 
 {

  
    $_SESSION['titles'][$slideNumber] = $newTitle;
    save_this_file('titles',$_SESSION['titles']);
    $_SESSION['widths'][$slideNumber] = $newWidth;
    save_this_file('widths',$_SESSION['widths']);
    $_SESSION['heights'][$slideNumber] = $newHeight;
    save_this_file('heights',$_SESSION['heights']);

    $newDescription = str_replace("\n", "", $newDescription);
    $newDescription = str_replace("\r", "", $newDescription);
    //$data[$i] = str_replace(PHP_EOL, "", $newDescription);

    $_SESSION['descriptions'][$slideNumber] = $newDescription;


    save_this_file('descriptions',$_SESSION['descriptions']);


}

function save_new_image_and_new_data($filename, $newTitle, $newWidth, $newHeight, $newDescription)
{
    // I am copying the session arrays to a local array before pushing and then re-assigning to Session vars.
    // for some reason the push didn't work on the Session vars directly.

    $names = $_SESSION['image_names'];
    array_push($names, $filename);
    $_SESSION['image_names'] = $names;

    $titles = $_SESSION['titles'];
    array_push($titles,$newTitle);
    $_SESSION['titles'] = $titles;

    $widths = $_SESSION['widths'];
    array_push($widths,$newWidth);
    $_SESSION['widths'] = $widths;

    $heights = $_SESSION['heights'];
    array_push($heights,$newHeight);
    $_SESSION['heights'] = $heights;

    $descriptions = $_SESSION['descriptions'];
    array_push($descriptions,$newDescription);
    $_SESSION['descriptions'] = $descriptions;


    foreach($_SESSION['image_names'] as $thisName)
    {
      echo $thisName . "<br>";
    }

    //array_push($_SESSION['image_names'], $filename);
   // echo $filename . "<br>";
    // foreach($_SESSION['image_names'] as $thisName)
    // {
    //   echo $thisName . "<br>";
    // }
    // array_push($_SESSION['titles'], $newTitle);
    // array_push($_SESSION['widths'], $newWidth);
    // array_push($_SESSION['heights'], $newHeight);
    // array_push($_SESSION['descriptions'], $newDescription);

    echo $_SESSION['path'] . " is the path";


    save_this_file('names',$_SESSION['image_names']);
    save_this_file('titles',$_SESSION['titles']);
    save_this_file('widths',$_SESSION['widths']);
    save_this_file('heights',$_SESSION['heights']);
    save_this_file('descriptions',$_SESSION['descriptions']);


}





?>