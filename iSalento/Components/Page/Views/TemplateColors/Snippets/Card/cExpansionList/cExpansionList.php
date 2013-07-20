<?php 
/** Isp_View_Snippet */
Isp_Loader::loadClass('Isp_View_Snippet');

/**
 * Contenitore delle espansioni articolo
 *	
 * EXAMPLE CODE:
 *	<div class="corpo_articolo">
 * 		Array di ArticleExpansion
 *	</div>    
 */
class cExpansionList extends Isp_View_Snippet{
	public $snippetType = "Card";
	
	/**
	 * Object state
	 */
	public $expansionArticleArray;
	
	/**
	 * Markup tags names (ids' & classes' names)
	 */
	public $classCorpoArticolo = 'corpo_articolo';
	
	/**
	 * Costructor
	 *
	 * @param Array $expansionArticleArray - array di ArticleExpansion
	 */
	public function __construct($expansionArticleArray, $color = null){
		// Store into object state
		$this->setState("expansionArticleArray",$expansionArticleArray);
		$this->setState("color",$color);
		
		parent::__contruct();
		
		// Render into father's code variable
		$this->run();	
	}
	
	public function render(){
		$code = $this->openTag(null, $this->classCorpoArticolo);
		foreach ($this->expansionArticleArray as $snippet) {
			$code .= $snippet->code;
		}
  		$code .= $this->closeTag();    
		return $code;
	}	
}
?>