<?php

function get_path() {
    $pieces = [];
    $path = getcwd();
   // echo "<br>FROM getcwd: " . $path;
    $pieces = explode("/", $path);
    $pieceCount = count($pieces);

    if ($pieces[$pieceCount-1] == "admin") {
        $path = "../";
    } else {
        $path ='';
    }
    return $path;
}

function get_resource_path($isLocal) {
  
        if ($isLocal) {
          //  echo "GETTING LOCAL RESOURCE PATH:<br>";
        $path = getcwd();
    
        $pieces = explode("/", $path);
        $piece = array_shift($pieces);
        $piece = array_shift($pieces);
        $piece = array_shift($pieces);
        $piece = array_shift($pieces);
       // print_r($pieces);
        
        $resource_path = join("/", $pieces);
        
    
        return "/". $resource_path."/";
        } 
        else {
          //  echo "GETTING LIVE RESOURCE PATH:<br>";
            return "/";
        }
    
}
?>