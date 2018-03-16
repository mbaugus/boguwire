<?php
   define('LOCATION', 'LOCAL'); // 'ONLINE/OFFLINE
   define('SHOW_SESSION', 'TRUE'); // prints out session info before header
   define('USESDB',  'FALSE');
   define('REDIRECT_TO_404_ON_ROUTING_ERROR', 'FALSE');

   require_once('route.php'); // access route class
   require_once('database.php'); // creates $db object, also begins session
   require_once('utility.php');

  // echo var_dump($_SESSION);
  if(!isset($_SESSION['sitename'])){
     if(constant('LOCATION') === 'LOCAL')
     {
       $_SESSION['sitename'] = 'blog';
     }
     else if(constant('LOCATION') === 'ONLINE')
     {
       $_SESSION['sitename'] = 'https://www.boguswire.com';
     }
  }

   $basepath = $_SERVER["DOCUMENT_ROOT"];

   if(!isset($_SESSION['basepath'])) {
     $_SESSION['basepath'] = $basepath;
   }

   $url = getUrlInfo();
   $route = new Route($db, $basepath, $url);
   
   if(constant('SHOW_SESSION') === 'TRUE'){
     $route->EchoRouteInfo();
     var_dump($_SESSION);
   }