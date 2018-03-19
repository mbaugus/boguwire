<?php
//require_once "./view.php";
//require_once "./utlity.php";

class BogusView extends View
{
    function __constructor($name = null){
        parent::construct($name);
        debug_to_console("name " . $name);
    }
    public function Body()
    {
        ?>
        <h1>Bogus Body</h1>
        <?php
    }
}

?>