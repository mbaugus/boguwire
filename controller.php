<?php

require_once('./utility.php');
require_once('./view.php');

class Controller
{
	private $routeInfo = null;
	private $viewData = null;

	function __constructor()
	{
	}

	public function Activate($routeInfo)
	{
		$this->routeInfo = $routeInfo;
		$this->ActivateAction();
	}

	protected function View($name = null)
	{
		if($name == null || $name = ""){
			$name = $this->routeInfo['controller'];
		}
		try{
			$fileName = $this->FindViewFile($name);
		}
		catch(Exception $e){
			throw e;
			return;
		}

		$this->routeInfo['UsingViewPath'] = $fileName;
		debug_to_console('View: ' . $fileName . " Name: " . $name);
		if($fileName == null){
			return $this->UnableToFindResource();
		}
		else{
			$view = $this->GetView($name, $fileName);
			if($view == null){
				return $this->UnableToFindResource();
			}
			else{
				$view->Activate();
			}
		}
	}
	private function FindViewFile($name)
	{
       require_once('utility.php');
	   $viewPath = './views/';
	   $viewLower = 'view';
	   $viewUpper = 'View';

	   $viewPathOriginal = $viewPath . $name . $viewLower . '.php';
	   $viewPathLower = $viewPath . strtolower($name) . $viewLower . '.php';
	   $viewPathUCFirst = $viewPath . ucfirst($name) . $viewLower . '.php';
	   $viewPathUpper = $viewPath . strtoupper($name) . $viewLower . '.php';

    	if( fileExists($viewPathOriginal)){
			return $viewPathOriginal;
        }
    	else if(fileExists($viewPathLower)){
			 return $viewPathLower;
		}
        else if(fileExists($viewPathUCFirst)){
			return $viewPathUCFirst;
		 }
		 else if(fileExists($viewPathUpper)){
			return $viewPathUpper;
		 }
		 else{
			 $msg = "Couldn't find view file path " . $viewPathOriginal
			 . ' ' . $viewPathLower . ' ' . $viewPathUCFirst . ' ' . $viewPathUpper;
			 debug_to_console($msg);
			return null;
		 }
	  }

	private function UnableToFindResource()
	{
		if(!defined("VIEW_ERROR_CLASS") || !defined("VIEW_RESOURCE_NOT_FOUND")){
			throw new Exception("No default bad resource view defined");
		}
		else{
			$errorView = $this->GetView(constant("VIEW_ERROR_CLASS"), constant("VIEW_RESOURCE_NOT_FOUND"));
			if($errorView == null){
				throw new Exception("Bad no resource VIEW found");
			}
			else{
				return $errorView->Activate();
			}
		}
	}
	private function GetView($name, $fileName)
	{
		require_once($fileName);

		$LowerName = strtolower($name);
    	$CapitalizedName = ucfirst($LowerName); 
    	$LowerView = "view";
    	$UpperView = "View";

    	$combo1 = $LowerName . $LowerView;
		$combo2 = $LowerName . $UpperView;
   		$combo3 = $CapitalizedName . $LowerView;
    	$combo4 = $CapitalizedName . $UpperView;

    	if(class_exists($combo1) ){
      		$this->routeInfo['UsingViewClass'] = $combo1;
      		$view = new $combo1();
      		return $view;
    	}
    	else if ( class_exists($combo2) ){
      		$this->routeInfo['UsingViewClass'] = $combo2;
      		$view = new $combo2();
      		return $view;
    	}
    	else if( class_exists($combo3) ){
      		$this->routeInfo['UsingViewClass'] = $combo3;
      		$view = new $combo3();
      		return $view;
    	}
    	else if( class_exists($combo4) ){
      		$this->routeInfo['UsingViewClass'] = $combo4;
			$view = new $combo4();
			return $view;
    	}
    	else{
      		$message = '<h4>Unable to find a view class by the name(s) of <br>' . $combo1 . ', ' . $combo2 . ', ' .  $combo3 . ', ' . $combo4 . ' within ' . $this->routeInfo['UsingPath'] . '</h4>';
      		throw new Exception($message);
    	}
  }
	
	public function SetViewData($data)
	{
		$this->viewData = $data;
	}

	private function ActivateAction($action = null)
	{
		require_once($this->routeInfo["UsingPath"]);
		
		$controllerName = $this->routeInfo["UsingControllerName"];
		$params = $this->routeInfo["params"];
		if($action == null){
			$action = isset($params[1]) ? $params[1] : null;
		}
    	if($action == null){ // must resolve to an index() if there is no action.  throw error if no index is defined.
    		$action = "index";
    	}

		debug_to_console("In Controller: " . $controllerName . " Action: " . $action);

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
			if($lowerAction == 'index'){
				$msg = "<h4>Unable to find a suitable action within the controller. " . $this->routeInfo["UsingControllerName"] . " " . $this->routeInfo["UsingPath"] . "<br>" . $lowerAction . ", " . $upperAction . ", " . $capitalAction . "<br>";  
				throw new Exception($msg);
			}
			else{
				return $this->ActivateAction("index");
			}
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