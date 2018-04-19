<?php

abstract class View
{
	protected $name = null;
	protected $viewData = null;
	protected $headerPathDefault = null;
	protected $footerPathDefault = null;
	protected $additionalScripts = "";

	 function __constructor($name = null)
	 {
		 $this->name = $name;
		 if($this->name != null){
			
		 }
		 debug_to_console("View name: " . $this->name);
	 }

	 function SetViewData($data)
	 {
		$viewData = $data;
	 }

	 function Activate()
	 {
		$this->Header();
		$this->Body();
		$this->Footer();
	 }

	 abstract function Body();

	 function Header()
	 { 
		if($this->headerPathDefault != null){
			include_once($this->headerPathDefault);
		}
		else{ 
			if(defined("VIEW_HEADER_DEFAULT")){
				include(constant("VIEW_HEADER_DEFAULT"));
			}
		}
		HeaderOutput($this->Source() );
	 }

	 protected function SetHeader($setHeaderToThis)
	 {
		 $this->headerPathDefault = $setHeaderToThis;
		 debug_to_console("Setting Header Path: " . $setFooterToThis);
	 }
	 function SetFooter($setFooterToThis)
	 {
		 $this->footerPathDefault = $setFooterToThis;
	 }

	 function Footer()
	 {
		if($this->headerPathDefault != null){
			include_once($this->headerPathDefault);
		}
		else{
			if(defined("VIEW_FOOTER_DEFAULT")){
				include(constant("VIEW_FOOTER_DEFAULT"));
			}	
		}
		FooterOutput();
	 }

	 function Source()
	 {
		$output = "";
		$sources = json_decode(file_get_contents("sources.json"), true);
		foreach ($sources['css'] as $css => $value) {
			$output .= "<link rel=\"stylesheet\" href=" . $value . ">";
		}

		foreach ($sources['js'] as $js => $value) {
			$output .= "<script src=" . $value . "></script>";
		}
		$output .= $this->additionalScripts;
		return $output;
	 }

}

?>