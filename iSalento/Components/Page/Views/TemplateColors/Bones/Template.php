<?php

class Template{
	
	public $snpArray = null;
	public $sideNav = null;
	public $extraNav = null;
	public $bread = null;
	public $footer = null;
	public $docType = null;
	public $cHead = null;
	public $header = null;
	public $cPage = null;
	public $analytics = null;
	
	
	public $color = null;
	
	public function __construct($color = null, $lang = null){
		
		if(isset($lang)){
			$lang = strtoupper($lang); // Capitalize
		}
		// Default
		Isp_Loader::loadVistaObj("Snippets","Meta","Doctype");
		$this->docType = new Doctype($lang);

		// Statistics - Google Analytics
		Isp_Loader::loadVistaObj("Snippets","Statistics","Analytics");
        $this->analytics = new Analytics();
        
		// Color
		$this->color = $color;
		
	}
	
	public function render(){
		// CENTRAL PAGE
		Isp_Loader::loadVistaObj("Snippets","Layout","cCentralPage");
		$cPage = new cCentralPage(	$this->snpArray, 
									$this->sideNav, 
									$this->extraNav, 
									$this->bread, 
									$this->footer);
		
		// WRAPPER
		Isp_Loader::loadVistaObj("Snippets","Layout","cWrapper");
		$wrap = new cWrapper(	$this->docType, 
								$this->cHead, 
								$this->header, 
								$cPage, 
								$this->color,
								false,
								$this->analytics);
		return $wrap->out();
	}
	

}

?>