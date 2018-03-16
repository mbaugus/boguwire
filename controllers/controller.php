<?php

require_once('./utility.php');

class Controller
{
	private $routeInfo = null;

	function __constructor($routeInfo)
	{
		$this->routeInfo = $routeInfo;
	}

	public function Activate()
	{
		$this->ActivateAction();
	}

	private function ActivateAction()
	{

		echo var_dump($this->routeInfo);
    	require_once($this->routeInfo["UsingPath"]);

    	$params = $this->routeInfo["params"];
    	$action = isset($params[1]) ? $params[1] : null;
        $controllerName = $this->routeInfo["UsingControllerName"];
    	if($action == null){ // must resolve to an index() if there is no action.  throw error if no index is defined.
    		$action = "index";
    	}

    	$lowerAction =  strtolower($action);
    	$upperAction = strtoupper($action);
    	$capitalAction = ucfirst($lowerAction);

    	if(method_exists($controllerName, $lowerAction)){
      		return $this->$lowerAction();
    	}
    	else if(method_exists($controllerName, $upperAction)){
      		return $this->$upperAction();
    	}
    	else if(method_exists($controllerName, $capitalAction)){
      		return $this->$capitalAction();
    	}
    	else{
    		$msg = "<h4>Unable to find a suitable action within the controller. " . $this->routeInfo["UsingControllerName"] . " " . $this->routeInfo["UsingPath"] . "<br>" . $lowerAction . ", " . $upperAction . ", " . $capitalAction . "<br>";  
    		throw new Exception($msg);
    	}


    	//$param1 = isset($this->param[2]) ? $this->param[2] : null;
    	//$param2 = isset($this->param[3]) ? $this->param[3] : null;
    	//$param3 = isset($this->param[4]) ? $this->param[4] : null;
    	//$param4 = isset($this->param[5]) ? $this->param[5] : null;

    //$newController->setAction($action);
    //$newController->setParam1($param1);
    //$newController->setParam2($param2);
    //$newController->setParam3($param3);
    //$newController->setParam4($param4);
    //$newController->activate();
	}


}

?>