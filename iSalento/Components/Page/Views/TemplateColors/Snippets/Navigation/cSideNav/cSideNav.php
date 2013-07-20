<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
Isp_Loader::loadVistaObj("Snippets","Navigation","SideListNav");

/**
 * EXAMPLE CODE:
 * <div id="navigazione_laterale">
 * 		SideListNav snippets
 * </div>
 */

/**
 * Abstraction of lefthand side navigation bar.
 * It contains multiple side bars.
 */
class cSideNav extends Isp_View_Snippet{
	public $snippetType = "Navigation";
		
	public $sideListNavArray; // Array of side bars
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $idSideNav = "navigazione_laterale";
	
	/**
	 * Constructor
	 *
	 * @param array $sideListNavArray - array of bars snippets
	 * @param string $extra = "extra" - if set it formats an extra 
	 * side bar (usually right bar). By default left bar is set.
	 */
	public function __construct($sideListNavArray, $extra=null){

		// Store into the object state
		$this->setState("sideListNavArray",$sideListNavArray);
		
		if(isset($extra)){
			$this->setState("idSideNav",$extra);
		}
		
		parent::__contruct();	
		
		// Render into father's code variable
		$this->run();	
		
	}
	
	public function render(){
		// Div navigazione_laterale
		$code = $this->openTag($this->idSideNav);
			// Tabs html code
			foreach ($this->sideListNavArray as $bar){
				if(isset($bar)){
					$code .= $bar->out();
				}
			}
		// Close div navigazione_laterale	
		$code .= $this->closeTag();
		return $code;
	}
	
}
?>