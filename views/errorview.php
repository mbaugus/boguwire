<?php

//require_once(__ROOT__ ."/view.php");
//require_once(__ROOT__ . "/utility.php");

//define('__ROOT__', dirname(dirname(__FILE__))); 
//require_once(__ROOT__.'/config.php'); 

class ErrorView extends View
{
    function __constructor($name = null){
        parent::construct($name);
        debug_to_console("name " . $name);
    }
    public function Body()
    {
        ?>
        <h1>Error 404 Body</h1>
        <?php
    }
}

?>