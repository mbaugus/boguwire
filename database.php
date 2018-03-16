<?php
if( !defined('LOCATION') ){
  die("Access denied.");
}

session_start();

// Include site constants
include_once 'constants.php';


if( constant('USESDB') === 'FALSE' ) 
{
	$db = null;
}
else if( constant('LOCATION') === 'LOCAL')
{
  $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
}
else
{
  $db = new mysqli(DB_HOST_REAL, DB_USER_REAL, DB_PASS_REAL, DB_NAME_REAL, 3306);
}

/*
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
    exit();
}*/
?>
