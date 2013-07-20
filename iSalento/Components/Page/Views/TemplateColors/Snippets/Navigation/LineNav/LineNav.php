<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');
/** Href snippet */
Isp_Loader::loadVistaObj("Snippets","Html","Href");

/**
 * EXAMPLE CODE:
 * <div id="percorso_pagina_corrente"> 
	  <a href="../../new grafica/new template/base.php" >Base</a> > 
	  <a href="../../new grafica/new template/base1.php" >Base 1</a> 
	</div>
 */

/**
 * Abstraction LineNav navigation
 */
class LineNav extends Isp_View_Snippet{
	public $snippetType = "Navigation";
	
	public $urlArray= array(); // Navigation urls, where in site am I?
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $idLineNav = "percorso_pagina_corrente"; // Bradcrumb default
	public $separator = null;
	
	/**
	 * Contructor
	 *
	 * @param array Isp_Url $urlArray 
	 * @param string|mixed $separator - separator between links
	 * @param string $tagName - a different tag name (for CSS)
	 */
	public function __construct($urlArray, $separator, $tagName=null){

		// Store into the object state
		$this->setState("urlArray",$urlArray);
		$this->separator = htmlentities($separator); // Ensure html
		
		if(isset($tagName)){ // Change default tag name (es. to "footer")
			$this->setState("idLineNav",$tagName);
		}
		
		parent::__contruct();		
		
		// Render
		$this->run();
	}
	
	public function render(){
		$code = $this->openTag($this->idLineNav);
			// Links
			foreach ($this->urlArray as $url){
				$href = new Href($url);
				$code .= $href->code;
				$code .= " ".$this->separator." ";			
			}
			// Trim last separator
			$code = rtrim($code," ".$this->separator." ");
		$code .= $this->closeTag();	
		return $code;
	}
}
?>