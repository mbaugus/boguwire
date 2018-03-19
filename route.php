<?php

include_once("utility.php");

class Route
{

  private $routeInfo = [
      'controller' => "",
      'action' => "",
      'UsingControllerName' => "",
      'UsingPath' => "",
      'UsingViewPath' => "",
      'UsingViewName' => "",
      'db' => null,
      'baseWebPath' => null,
      'params' => null
  ];

  function __construct($db, $basepath, $param)
  {
     $this->routeInfo["db"] = $db;
     $this->routeInfo["baseWebPath"] = $basepath;
     $this->routeInfo["params"] = $param;

     try
     {
      // gets the file path for the controller, ***can throw if path doesnt exist***
      $controllerPath = $this->GetControllerPath();
      
      // gets the class inside the file, ***can throw if the class doesnt exist***
      //debug_to_console("Get controlled");
      $mcontroller = $this->GetController();
      $mcontroller->Activate($this->routeInfo);
      // we should have a real active controller class here,  but now we need an action for the controller, this can throw if no index()
     // $controller->Activate($this->routeInfo);
     }
     catch(Exception $e)
     {
      if( constant('REDIRECT_TO_404_ON_ROUTING_ERROR') === 'FALSE' ) {
       debug_to_console($e->getMessage());
       echo $e->getMessage();
      }
      else{
         return new View("404");
      }
     }

     
     //$this->activateControl($controller);
  }

  public function EchoRouteInfo()
  {
    debug_to_console(var_dump($this->routeInfo));
  }
  // instead of a switch, we could store these in a database or use an associative array, but the list of controllers are very limited, it wont get out of control.  IF it did I would move it to an array.
  public function GetControllerPath()
  {
       require_once('utility.php');
       
       $controllerPath = 'controllers/';
       $controller = isset($this->routeInfo['params'][0]) ? $this->routeInfo['params'][0] : null;
       $this->routeInfo["controller"] = $controller;
       $this->routeInfo['UsingControllerName'] = $controller;

       if($controller === null){
         $this->routeInfo["controller"] = 'main';
         $this->routeInfo['UsingControllerName'] = 'main';
         if(fileExists($controllerPath . 'mainController.php')){
           $this->routeInfo['UsingPath'] = $controllerPath . 'mainController.php';
         }
         else if(fileExists($controllerPath . 'main.php')){
           $this->routeInfo['UsingPath'] = $controllerPath . 'main.php';
         }
         else{
          throw new Exception("<h4>Unable to find a main controller.</h4>");
         }
       }
       else
       {
         if(fileExists($controllerPath . $controller . 'controller.php')){
          $this->routeInfo['UsingPath'] = $controllerPath . $controller . 'controller.php'; 
         }
         else if(fileExists($controllerPath . $controller . '.php')){
          $this->routeInfo['UsingPath'] = $controllerPath . $controller . '.php';
         }
         else{
           throw new Exception("<h4>Unable to find a controller.</h4>" . $controller);
         }
      }
  }

  /// USES this->UsingControllerName  and $this->UsingPath that is set on the previous function GetControllerPath
  /// So no need to pass informaiton into it

  public function GetController()
  {
    include($this->routeInfo['UsingPath']);
    debug_to_console($this->routeInfo['UsingPath']);
    $LowerName = strtolower($this->routeInfo['UsingControllerName']);
    $CapitalizedName = ucfirst($LowerName); 
    $LowerController = "controller";
    $UpperController = "Controller";

    $combo1 = $LowerName . $LowerController;
    $combo2 = $LowerName . $UpperController;
    $combo3 = $CapitalizedName . $LowerController;
    $combo4 = $CapitalizedName . $UpperController;

    debug_to_console($combo1);
    if(class_exists($combo1) ){
      $this->routeInfo['UsingControllerName'] = $combo1;
      $controller = new $combo1();
      return $controller;
    }
    else if ( class_exists($combo2) ){
      $this->routeInfo['UsingControllerName'] = $combo2;
      $controller = new $combo2();
      return $controller;
    }
    else if( class_exists($combo3) ){
      $this->routeInfo['UsingControllerName'] = $combo3;
      $controller = new $combo3();
      return $controller;
    }
    else if( class_exists($combo4) ){
      $this->routeInfo['UsingControllerName'] = $combo4;
      $controller = new $combo4();
      return $controller;
    }
    else{
      $message = '<h4>Unable to find a class by the name(s) of <br>' . $combo1 . ', ' . $combo2 . ', ' .  $combo3 . ', ' . $combo4 . ' within ' . $this->routeInfo['UsingPath'] . '</h4>';
      throw new Exception($message);
    }
  }

// left very generic here, so controller file must match the name of the returned controller in GetController()
  public function activateControl($controllerName)
  {
    $cp = '/controllers/';
    $p = $_SERVER["DOCUMENT_ROOT"] . $cp . $controllerName . '.php';
    require_once $p;
    $newController = new $controllerName($this->db, $this->basePath);
    $action = isset($this->param[1]) ? $this->param[1] : null;
    $param1 = isset($this->param[2]) ? $this->param[2] : null;
    $param2 = isset($this->param[3]) ? $this->param[3] : null;
    $param3 = isset($this->param[4]) ? $this->param[4] : null;
    $param4 = isset($this->param[5]) ? $this->param[5] : null;

    $newController->setAction($action);
    $newController->setParam1($param1);
    $newController->setParam2($param2);
    $newController->setParam3($param3);
    $newController->setParam4($param4);
    $newController->activate();
  }
}

?>
