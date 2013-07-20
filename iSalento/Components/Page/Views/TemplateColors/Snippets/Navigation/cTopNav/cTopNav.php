<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
Isp_Loader::loadVistaObj("Snippets","Navigation","cTopNavTab");

/**
 * Abstraction of complete top navigation bar.
 * It is made of sinble cTopNavTab snippets.
 */
class cTopNav extends Isp_View_Snippet{
	public $snippetType = "Navigation";
		
	public $cTopTabNavArray; // Array of Tabs
	public $color=null; // Current section color
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $idNavigazione = "navigazione";
	public $idPoint = "point";
	
	/**
	 * Constructor
	 *
	 * @param array $cTopTabNavArray - tabs snippets
	 */
	public function __construct($cTopTabNavArray,$color=null){

		// Store into the object state
		$this->setState("cTopTabNavArray",$cTopTabNavArray);
		$this->setState("color",$color);
		
		parent::__contruct();		
		
		// Render code into father's code variable
		$this->run();
	}

	public function render(){
		// Div navigazione
		$code = $this->openTag($this->idNavigazione);
			// Ul point
			$code .= $this->openTag($this->idPoint,null,"ul");
			
				// Tabs html code
				foreach ($this->cTopTabNavArray as $tab){
					// First item (round corner image)
					if($tab == $this->cTopTabNavArray[0]){
						$tab->firstLast = "first";
					}
					// Last item (round corner image)
					if($tab == end($this->cTopTabNavArray)){
						$tab->firstLast = "last";
					}
					$tab->currentColor = $this->color; // Set current color
					$tab->run(); // Render tab code
					$code .= $tab->code;
				}
			// Close ul point	
			$code .= $this->closeTag("ul");
		// Close div navigazione	
		$code .= $this->closeTag();
		return $code;
	}

	/*
	public function defineCss(){
		$this->appendCss($this->getDefaultCss());
		$this->appendCss($this->cTopTabNavArray[0]->cssList);
	}
	*/
}
?>