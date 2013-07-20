<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');

/**
 * Clear for floating elements.
 * 
 * EXAMPLE CODE:
 	<div class="clear_left">&nbsp;</div>
 	or
 	<div class="clear_both"/>
 */
 
class Clear extends Isp_View_Snippet{
	public $snippetType = "Html";
	
	/**
	 * Object state
	 */
	public $type = null;
	public $spaceOption = false; 
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $classClear = "clear_";
	
	/**
	 * Constructor
	 *
	 * @param string $type - "left or both"
	 * @param Boolean $spaceOption - add &nbsp;
	 */
	public function __construct($type, $spaceOption= false){
									
		// Store into object state
		$this->setState("type",$type);
		$this->setState("spaceOption",$spaceOption);
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	public function render(){
		
		$code = $this->openTag(null, $this->classClear.$this->type);
		if($this->spaceOption){
			$code .= "&nbsp;";
		}
		$code .= $this->closeTag();
		return $code;
	
	}	
}
?>