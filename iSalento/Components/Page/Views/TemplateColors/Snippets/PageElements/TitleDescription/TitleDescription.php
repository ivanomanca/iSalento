<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');

/**
 * It contains title and description of the page
 *	
 * EXAMPLE CODE:
 * <div class="titolo_pagina">
       <h1>Titolo</h1>
    </div>
    <div class="descrizione_pagina"> 
		Questa è la descrizione della pagina.
	</div>
 */
 
class TitleDescription extends Isp_View_Snippet{
	
	public $snippetType = "PageElements";
	
	/**
	 * Object state
	 */
	public $title = null; 
	public $description = null; 
	public $format = null;
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $classTitle = "titolo_pagina";
	public $classDescription = "descrizione_pagina";
	
	
	/**
	 * Contructor
	 *
	 * @param string $title - the page title
	 * @param string $description - a short page description
	 */
	public function __construct($title, $description = null){
		
		// First letter capital
		$title = ucwords($title);
		
		// Store into object state
		$this->setState("title", $title);
		$this->setState("description", $description);
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	public function render(){
		
    	// Div page title
    	$code = $this->openTag(null, $this->classTitle);
    		$code .= "<h1>".$this->title."</h1>";
    	$code .= $this->closeTag();
    	
		// Div page description
		if(isset($this->description)){
			$code .= $this->openTag(null, $this->classDescription);
				$code .= $this->description;
			$code .= $this->closeTag();
		}
		
		return $code;
	}	
	
}
?>