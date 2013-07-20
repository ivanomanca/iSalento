<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
Isp_Loader::loadVistaObj("Snippets","List","cListItem");

/**
 * It contains an array of list items
 *	
 * EXAMPLE CODE:
 * 	<div class="lista">
 * 	cListItems
 *  </div>
 */
 
class cList extends Isp_View_Snippet{
	public $snippetType = "List";
	
	/**
	 * Object state
	 */
	public $itemsArray = null; 
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $classList = "lista_articolo";
	
	/**
	 * Constructor
	 * 
	 * @param array $itemsArray - cListItem snippets
	 */
	public function __construct($itemsArray){
		// Store into object state
		$this->setState("itemsArray",$itemsArray);
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	public function render(){
		// Div lista
		$code = $this->openTag(null,$this->classList);
		foreach ($this->itemsArray as $item){
			$code .= $item->code;
		}
		$code .= $this->closeTag();
		return $code;
	}	
	
	
}
?>