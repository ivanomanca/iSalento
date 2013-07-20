<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
Isp_Loader::loadVistaObj("Snippets","Navigation","cTopNav");
Isp_Loader::loadVistaObj("Snippets","Layout","Testata");

/**
 * Wrapper for top navigation bar, logo and 180¡ picture
 * 
 */
class cHeader extends Isp_View_Snippet{
	public $snippetType = "Layout";
	
	public $cTopNav;
	public $testata;
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $idHeader = "header";
	
	
	public function __construct(cTopNav $cTopNav,Testata $testata){

		// Store into the object state
		$this->setState("cTopNav",$cTopNav);
		$this->setState("testata",$testata);
		
		parent::__contruct();		
		
		// Render into father's code variable
		$this->run();	
		
	}
	
	public function render(){
		// Div header
		$code = $this->openTag($this->idHeader);
			// Top navigation bar snippet
			$code .= $this->cTopNav->code;
			// Testata snippet
			$code .= $this->testata->code;
		// Close header
		$code .= $this->closeTag();
		return $code;
	}
	
}
?>