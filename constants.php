<?php
if( !defined('LOCATION') ){
  die("Access denied.");
}

   // VIEW FOOTER DEFAULT
   define("VIEW_HEADER_DEFAULT", './views/shared/header.php');
   // VIEW HEADER DEFAULT
   define("VIEW_FOOTER_DEFAULT", './views/shared/footer.php');
   // NO RESOURCE FOUND VIEW
   define("VIEW_RESOURCE_NOT_FOUND", './views/errorview.php');
   define("VIEW_ERROR_CLASS", "Error");
   // DEBUG_CONSOLE_LOG function will display if true
   define("DEBUG_CONSOLE", 'TRUE');

   define('__ROOT__', dirname(dirname(__FILE__))); 

    // Database credentials
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'users');

    define('DB_HOST_REAL', '');
    define('DB_USER_REAL', '');
    define('DB_PASS_REAL', '');
    define('DB_NAME_REAL', '');

    define('DB_FORUM_HOST', 'localhost');
    define('DB_FORUM_USER', 'root');
    define('DB_FORUM_PASS', '');
    define('DB_FORUM_NAME', 'forums');

    define('DB_FORUM_HOST_REAL', '');
    define('DB_FORUM_USER_REAL', '');
    define('DB_FORUM_PASS_REAL', '');
    define('DB_FORUM_NAME_REAL', '');

    define('DB_TICKET_HOST', 'localhost');
    define('DB_TICKET_USER', 'root');
    define('DB_TICKET_PASS', '');
    define('DB_TICKET_NAME', 'tickets');

    define('DB_TICKET_HOST_REAL', '');
    define('DB_TICKET_USER_REAL', '');
    define('DB_TICKET_PASS_REAL', '');
    define('DB_TICKET_NAME_REAL', '');
?>
