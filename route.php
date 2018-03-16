<?php
class Route
{

  private $routeInfo = [
      'UsingControllerName' => "",
      'UsingPath' => "",
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
      $controller = $this->GetController();
      // we should have a real active controller class here,  but now we need an action for the controller, this can throw if no index()
      $controller->Activate($this->routeInfo);
     }
     catch(Exception $e)
     {
      if( constant('REDIRECT_TO_404_ON_ROUTING_ERROR') === 'FALSE' ) {
       echo $e->getMessage();
       return;
      }
      else{
         return new View("404");
      }
     }

     
     //$this->activateControl($controller);
  }

  public function EchoRouteInfo()
  {
      var_dump($this->routeInfo);
  }
  // instead of a switch, we could store these in a database or use an associative array, but the list of controllers are very limited, it wont get out of control.  IF it did I would move it to an array.
  public function GetControllerPath()
  {
       require_once('utility.php');

       $controllerPath = 'controllers/';
       $controller = isset($this->routeInfo['params'][0]) ? $this->routeInfo['params'][0] : null;

       $this->routeInfo['UsingControllerName'] = $controller;

       if($controller === null){
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
    
    $LowerName = strtolower($this->routeInfo['UsingControllerName']);
    $CapitalizedName = ucfirst($LowerName); 
    $LowerController = "controller";
    $UpperController = "Controller";

    $combo1 = $LowerName . $LowerController;
    $combo2 = $LowerName . $UpperController;
    $combo3 = $CapitalizedName . $LowerController;
    $combo4 = $CapitalizedName . $UpperController;

    if(class_exists($combo1) ){
      return new $combo1();
    }
    else if ( class_exists($combo2) ){
      return new $combo2();
    }
    else if( class_exists($combo3) ){
      return new $combo3();
    }
    else if( class_exists($combo4) ){
      return new $combo4();
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
