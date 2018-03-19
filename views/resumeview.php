<?php
//require("./view.php");

class ResumeView extends View
{
    function __constructor($name = null){
        parent::construct($name);
    }
    function Body()
    {
        ?>
        <main role="main">
            <div class="container">
            <h1 class="cover-heading">Resumè</h1>
        <p class="lead">This is a resumè</p>
    </div>
      </main>

        <?php
    }
}

?>