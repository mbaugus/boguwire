<?php

function fileExists($fileName, $caseSensitive = true) {

    if(file_exists($fileName)) {
        return $fileName;
    }
    if($caseSensitive) return false;

    // Handle case insensitive requests            
    $directoryName = dirname($fileName);
    $fileArray = glob($directoryName . '/*', GLOB_NOSORT);
    $fileNameLowerCase = strtolower($fileName);
    foreach($fileArray as $file) {
        if(strtolower($file) == $fileNameLowerCase) {
            return $file;
        }
    }
    return false;
}

// takes the base site name from the url and the following slash, also removes ? and anything afterwards.
// returns false is you dont include the the basic /sitename/ .
// if they dont have anything it returns 'main'
function getUrlInfo()
{
  $url =  "{$_SERVER['REQUEST_URI']}";
  $url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
  $parse = parse_url($url);
  $url = rtrim($parse['path'], '/');
  $url = strtolower($url);
  $filtered = array_filter(explode('/', $url));
  $filtered = array_values($filtered);
  return $filtered;
}

function debug_to_console( $data ) {
    if(constant("DEBUG_CONSOLE") == 'FALSE'){
        return;
    }
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug: " . $output . "' );</script>";
}



?>