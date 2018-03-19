<?php

class MainView extends View
{
    function __constructor($name = null){
        //parent::construct($name);
        debug_to_console("name " . $name);
        $this->headerPathDefault = 'shared/header.no.navigation.php';
        $this->additionalScripts = "./js/main.js";
        $this->SetHeader('shared/header.no.navigation.php');
    }
    public function Body()
    {
        ?>
        <video id="video" src="/images/screenparticles.mov" controls="false" autoplay="true" style="display:none"></video>
        <canvas id="canvas"></canvas>
  <div class="main text-center">
    <h1 class="cover-heading">Bogus Wire</h1>
    
    <p class="lead">This is my website and blog for all things technology related.  Enjoy!</p>
    <p class="lead"><b>Ian is great at reading!!</b></p>
    <p>And so is his brother Gabriel</p>
    <p>You rock dude</p>
      <a href="/blog" class="btn btn-primary mybtn btn-lg">Blog</a>
      <a href="/about" class="btn btn-primary mybtn btn-lg">About me</a>
      <a href="/projects" class="btn btn-primary mybtn btn-lg">Projects</a>  
   </div>
        <?php
    }
}

?>