<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
/** Li snippet */
Isp_Loader::loadVistaObj("Snippets","Html","Li");

/**
 * Conceptual list of arguments.
 *	
 * EXAMPLE CODE:
 * 	<ul id="indice">
      <li><a href="#prima_parte">Prima parte</a></li>
      <li><a href="#seconda_parte">Seconda parte</a></li>
      <li><a href="#terza_parte">Terza parte</a></li>
    </ul>
     
 */


class AtAGlance extends Isp_View_Snippet{
	public $snippetType = "PageElements";
	
	/**
	 * Object state
	 */
	public $titleHeader = null;
	public $urlArray = null; 
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $idGlance = 'indice'; 

	
	/**
	 * Constructor
	 * 
	 * @param string $titleHeader - title to put on header (for case block)
	 * @param array $liArray - Array of Isp_Url objects
	 */
	public function __construct($titleHeader, $urlArray){
		// Store into object state
		$this->setState("titleHeader",$titleHeader);
		$this->setState("urlArray",$urlArray);
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	public function render(){
		// Open unordered list
		$code = $this->openTag($this->idGlance,null,"ul");
			// Single items of the list
			foreach ($this->urlArray as $url){
				$li = new Li($url);
				$code .= $li->code;
			}
		$code .= $this->closeTag("ul");
		return $code;
	}	

}
?>